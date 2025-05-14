<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaRequest;
use App\Models\Cnae;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Requerente;
use App\Models\Requerimento;
use App\Models\Setor;
use App\Models\Telefone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleXMLElement;

class EmpresaController extends Controller
{
    /**
     * Lista das empresas do requerente.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isRequerente', User::class);
        $empresas = auth()->user()->empresas;
        $requerentes = Requerente::all();

        return view('empresa.index', compact('empresas', 'requerentes'));
    }

    /**
     * Lista de todas as empresas.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEmpresas()
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $requerentes = Requerente::all();

        return view('empresa.index-empresas', ['requerentes' => $requerentes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Empresa::class);

        $setores = Setor::orderBy('nome')->get();

        $empresa = session('empresa');

        return view('empresa.create', compact('setores', 'empresa'));
    }

    public function licencasIndex(Request $request)
    {
        $empresa = Empresa::find($request->empresa);
        $requerimentos = Requerimento::where([['empresa_id', $empresa->id], ['status', '!=', Requerimento::STATUS_ENUM['cancelada']], ['cancelada', false]])->get();
        $tipos = Requerimento::TIPO_ENUM;

        return view('empresa.index-licenca', compact('requerimentos', 'empresa', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\EmpresaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpresaRequest $request)
    {
        $this->authorize('store', Empresa::class);

        $enderecoEmpresa = new Endereco();
        $telefoneEmpresa = new Telefone();
        $empresa = new Empresa();
        $enderecoEmpresa->setAtributesEmpresa($request->all());
        $enderecoEmpresa->save();
        $telefoneEmpresa->setNumero($request->celular_da_empresa);
        $telefoneEmpresa->save();
        $empresa->setAtributes($request->all());

        if(!Auth::user()->tipoAnalista->contains('tipo', 1)){
            $empresa->user_id = auth()->user()->id;
        }else{
            $empresa->user_id = User::where('role', 4)->first()->id;
        }

        $empresa->endereco_id = $enderecoEmpresa->id;
        $empresa->telefone_id = $telefoneEmpresa->id;
        $empresa->save();

        $empresa->cnaes()->attach($request->cnaes_id);

        if(!Auth::user()->tipoAnalista->contains('tipo', 1)){
            return redirect(route('empresas.index'))->with(['success' => 'Empresa cadastrada com sucesso!']);
        }else{
            return redirect()->route('empresas.listar')->with(['success' => 'Empresa cadastrada com sucesso!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $empresa = Empresa::find($id);
        $requerentes = Requerente::all();

        return view('empresa.show', compact('empresa', 'requerentes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($empresa_id)
    {
        if(session('empresa')){
            $empresa = (object) session('empresa');
            $empresa->id = $empresa_id;
        }else{
            $empresa = Empresa::find($empresa_id);
        }
        $this->authorize('update', $empresa);
        $setores = Setor::orderBy('nome')->get();

        return view('empresa.edit', compact('setores', 'empresa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EmpresaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmpresaRequest $request, $empresa_id)
    {
        $empresa = Empresa::find($empresa_id);
        $this->authorize('update', $empresa);

        $endereco = $empresa->endereco;
        $telefone = $empresa->telefone;

        //Adicionando
        foreach ($request->cnaes_id as $cnae_id) {
            if ($empresa->cnaes()->where('cnae_id', $cnae_id)->first() == null) {
                $empresa->cnaes()->attach((Cnae::find($cnae_id)));
            }
        }

        //Excluindo
        foreach ($empresa->cnaes as $cnae) {
            if (! (in_array($cnae->id, $request->cnaes_id))) {
                $empresa->cnaes()->detach($cnae->id);
            }
        }

        $endereco->setAtributesEmpresa($request->all());
        $endereco->update();
        $telefone->setNumero($request->celular_da_empresa);
        $telefone->update();

        $empresa->setAtributes($request->all());
        $empresa->update();

        if(!Auth::user()->tipoAnalista->contains('tipo', 1)){
            return redirect(route('empresas.index'))->with(['success' => 'Empresa cadastrada com sucesso!']);
        }else{
            return redirect()->route('empresas.listar')->with(['success' => 'Empresa cadastrada com sucesso!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        $this->authorize('delete', $empresa);

        $requerimentosPendentes = $empresa->requerimentos()->where([['status', '!=', Requerimento::STATUS_ENUM['finalizada']], ['status', '!=', Requerimento::STATUS_ENUM['cancelada']]])->get();
        if ($requerimentosPendentes->count() > 0) {
            return redirect()->back()->with(['error' => 'Essa empresa tem requerimentos pendentes e não pode ser deletada.']);
        }

        $endereco = $empresa->endereco;
        $telefone = $empresa->telefone;

        foreach ($empresa->cnaes as $cnae) {
            $empresa->cnaes()->detach($cnae->id);
        }

        $empresa->delete();
        $endereco->delete();
        $telefone->delete();

        return redirect(route('empresas.index'))->with(['success' => 'Empresa deletada com sucesso!']);
    }

    public function statusRequerimento(Request $request)
    {
        $empresa = Empresa::find($request->empresa_id);
        $qtd_requerimentos = $empresa->requerimentos()
            ->where('status', '!=', Requerimento::STATUS_ENUM['cancelada'])
            ->where('cancelada', false)
            ->count();
        if ($qtd_requerimentos == 0) {
            return response()->json([
                [
                    'tipo' => 'Primeira licença',
                    'enum_tipo' => Requerimento::TIPO_ENUM['primeira_licenca'],
                ],
            ]);
        }

        return response()->json([
            [
                'tipo' => 'Primeira licença',
                'enum_tipo' => Requerimento::TIPO_ENUM['primeira_licenca'],
            ],
            [
                'tipo' => 'Renovação',
                'enum_tipo' => Requerimento::TIPO_ENUM['renovacao'],
            ],
            [
                'tipo' => 'Autorização',
                'enum_tipo' => Requerimento::TIPO_ENUM['autorizacao'],
            ],
        ]);
    }

    public function pesquisa(Request $request)
    {
        $empresas = Empresa::search($request->search)->get();
        return response()->json($empresas);
    }

    public function importXml(Request $request){
        $this->authorize('create', Empresa::class);
        $xml = simplexml_load_file($request->file('empresa_xml')->getRealPath())->ROWSET;
        $cep = (String) $xml->RUC_COMP->RCO_ZONA_POSTAL;
        $empresa = (object)[
            'nome' => (string) $xml->RUC_GENERAL->RGE_NOMB,
            'contato' =>  (function($num) {
                                $num = preg_replace('/\D/', '', trim((string) $num));
                                return strlen($num) === 11
                                    ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $num)
                                    : preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $num);
                            })($xml->GROUPRUC_GEN_PROTOCOLO->RUC_GEN_PROTOCOLO[1]->RGP_VALOR) ,
            'cep' => (string) preg_replace("/(\d{5})(\d{3})/", "$1-$2", $xml->RUC_COMP->RCO_ZONA_POSTAL),
            'numero' => (string) trim($xml->RUC_ESTAB->RES_NUME),
            'cnpj' => (string) preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", trim($xml->PSC_PROTOCOLO->CNPJ)),
            'logradouro' => (string) $xml->RUC_COMP->RCO_TTL_TIP_LOGRADORO . ' ' . (string) $xml->RUC_COMP->RCO_DIRECCION,
            'bairro' => (string) $xml->RUC_COMP->RCO_URBANIZACION

        ];

        if($empresa_existente = Empresa::where('cpf_cnpj',preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $empresa->cnpj))->first()){
            session()->flash('comparativo', true);
            $empresa_upload = $empresa;
            $setores = Setor::orderBy('nome')->get();
            return view('empresa.create', compact('empresa_existente', 'empresa_upload', 'setores'));

        }
        session()->flash('empresa', $empresa);

        return redirect()->route('empresas.create', compact('empresa'));
    }

    public function comparativo(Request $request, $empresa_id){
        $empresa_temp = Empresa::find($empresa_id);

        $empresa = (object)[
            'nome' => $request->nome_escolhido,
            'telefone' => $request->telefone_escolhido,
            'cep' => $request->cep_escolhido,
            'numero' => $request->numero_escolhido,
            'cnpj' => $request->cnpj_escolhido,
            'logradouro' => $request->logradouro_escolhido,
            'bairro' => $request->bairro_escolhido,
            'eh_cnpj' => true,
            'setor' => $empresa_temp->cnaes->first()->setor->only(['id', 'nome']),
            'cnaes' => $empresa_temp->cnaes

        ];

        session()->put('empresa', $empresa);

        return redirect()->route('empresas.edit', compact('empresa_id'));
    }

    public function updateRequerente(Request $request)
    {
        $empresa = Empresa::find($request->empresa_id);

        if($this->authorize('isSecretario', User::class)){
            $empresa->user_id = $request->user_id;
        }
        $empresa->update();

        return redirect(route('empresas.listar'))->with(['success' => 'Requerente atualizado com sucesso!']);
    }
}
