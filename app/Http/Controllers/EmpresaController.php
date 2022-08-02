<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmpresaRequest;
use App\Models\User;
use App\Models\Setor;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\Cnae;
use App\Models\Requerimento;

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

        return view('empresa.index', compact('empresas'));
    }

    /**
     * Lista de todas as empresas.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEmpresas()
    {
        $this->authorize('isSecretarioOrAnalista', User::class);
        $empresas = Empresa::orderBy('nome')->paginate(20);

        return view('empresa.index-empresas', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('isRequerente', User::class);
        $setores = Setor::orderBy('nome')->get();

        return view('empresa.create', compact('setores'));
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
        $this->authorize('isRequerente', User::class);
        $enderecoEmpresa = new Endereco();
        $telefoneEmpresa = new Telefone();
        $empresa = new Empresa();
        $enderecoEmpresa->setAtributesEmpresa($request->all());
        $enderecoEmpresa->save();
        $telefoneEmpresa->setNumero($request->celular_da_empresa);
        $telefoneEmpresa->save();
        $empresa->setAtributes($request->all());
        $empresa->user_id = auth()->user()->id;
        $empresa->endereco_id = $enderecoEmpresa->id;
        $empresa->telefone_id = $telefoneEmpresa->id;
        $empresa->save();

        foreach ($request->cnaes_id as $cnae_id) {
            $empresa->cnaes()->attach((Cnae::find($cnae_id)));
        }

        return redirect(route('empresas.index'))->with(['success' => 'Empresa cadastrada com sucesso!']);
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

        return view('empresa.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresa = Empresa::find($id);
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
    public function update(EmpresaRequest $request, $id)
    {
        $empresa = Empresa::find($id);
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
            if (!(in_array($cnae->id, $request->cnaes_id))) {
                $empresa->cnaes()->detach($cnae->id);
            }
        }

        $endereco->setAtributesEmpresa($request->all());
        $endereco->update();
        $telefone->setNumero($request->celular_da_empresa);
        $telefone->update();

        $empresa->setAtributes($request->all());
        $empresa->update();

        return redirect(route('empresas.index'))->with(['success' => 'Empresa editada com sucesso!']);
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

        if ($empresa->requerimentos()->where('status', '!=', Requerimento::STATUS_ENUM['cancelada'])->get()->count() == 0) {
            return response()->json([
                [
                    'tipo' => 'Primeira licença',
                    'enum_tipo' => Requerimento::TIPO_ENUM['primeira_licenca'],
                ],
            ]);
        }
        return response()->json([
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
}
