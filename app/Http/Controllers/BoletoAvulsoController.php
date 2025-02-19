<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\User;
use App\Models\Requerente;
use App\Models\BoletoAvulso;
use App\Mail\CriacaoUsuarioPadrao;
use App\Http\Controllers\WebServiceCaixa\XMLCoderController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use PDF;

class BoletoAvulsoController extends Controller
{
    public function index() {
        return view('boletosAvulsos.index');
    }

    public function listar_boletos(Request $request, $filtragem)
    {
        $busca = $request->buscar;

        $this->authorize('isSecretarioOrFinanca', auth()->user());

        if(!in_array($filtragem, ['pendentes', 'pagos', 'vencidos', 'cancelados'])) {
            $filtragem = 'pendentes';
        }

        $retorno = $this->filtrarBoletos($request);
        $vencidos = $retorno[0];
        $pendentes = $retorno[1];
        $pagos = $retorno[2];
        $cancelados = $retorno[3];
        $dataAte = $retorno[4];
        $dataDe = $retorno[5];
        $filtro = $retorno[6];

        switch ($filtragem) {
            case 'pendentes':
                $pagamentos = $pendentes;
                break;
            case 'pagos':
                $pagamentos = $pagos;
                break;
            case 'vencidos':
                $pagamentos = $vencidos;
                break;
            case 'cancelados':
                $pagamentos = $cancelados;
                break;
        }

        if($busca != null){
            $empresas = Empresa::where('nome', 'ilike', '%'. $busca .'%')->get();
            $empresas = $empresas->pluck('id');
            $pagamentos = BoletoAvulso::whereIn('empresa_id', $empresas)->paginate(20);
            // $requerimentos = $requerimentos->pluck('id');
            // $pagamentos = BoletoAvulso::WhereIn('requerimento_id', $requerimentos)->paginate(20);
        }


        return view('boletosAvulsos.listar_boletos', compact('pagamentos', 'dataAte', 'dataDe', 'filtro', 'filtragem', 'busca'));
    }

    private function filtrarBoletos(Request $request)
    {
        $dataAte = $request->dataAte;
        $dataDe = $request->dataDe;
        $filtro = $request->filtro;
        $vencidos = BoletoAvulso::where('status_pagamento', BoletoAvulso::STATUS_PAGAMENTO_ENUM['vencido']);
        $cancelados = BoletoAvulso::where('status_pagamento', BoletoAvulso::STATUS_PAGAMENTO_ENUM['cancelado']);
        $pendentes = BoletoAvulso::where(function ($qry) {
            $qry->whereNull('status_pagamento')
                ->orWhere('status_pagamento', BoletoAvulso::STATUS_PAGAMENTO_ENUM['nao_pago']);
        });
        $pagos = BoletoAvulso::where('status_pagamento', BoletoAvulso::STATUS_PAGAMENTO_ENUM['pago']);
        $condicao = 'vencimento' == $filtro ? 'data_vencimento' : 'created_at';
        if ($dataDe != null) {
            $vencidos = $vencidos->where($condicao, '>=', $dataDe);
            $pendentes = $pendentes->where($condicao, '>=', $dataDe);
            $pagos = $pagos->where($condicao, '>=', $dataDe);
            $cancelados = $cancelados->where($condicao, '>=', $dataDe);
        }
        if ($dataAte != null) {
            $vencidos = $vencidos->where($condicao, '<=', $dataAte);
            $pendentes = $pendentes->where($condicao, '<=', $dataAte);
            $pagos = $pagos->where($condicao, '<=', $dataAte);
            $cancelados = $cancelados->where($condicao, '<=', $dataAte);
        }
        $vencidos = $vencidos->orderBy('created_at', 'DESC')->paginate(20);
        $pendentes = $pendentes->orderBy('created_at', 'DESC')->paginate(20);
        $pagos = $pagos->orderBy('created_at', 'DESC')->paginate(20);
        $cancelados = $cancelados->orderBy('created_at', 'DESC')->paginate(20);

        return [$vencidos, $pendentes, $pagos, $cancelados, $dataAte, $dataDe, $filtro];
    }

    public function gerarRelatorioBoletos(Request $request)
    {
        $retorno = $this->filtrarBoletos($request);

        $pdf = PDF::loadview('pdf/boletosAvulsos', ['vencidos' => $retorno[0], 'pendentes' => $retorno[1], 'pagos' => $retorno[2],
            'cancelados' => $retorno[3], 'dataAte' => $retorno[4], 'dataDe' => $retorno[5], 'filtro' => $retorno[6], ]);

        return $pdf->setPaper('a4')->stream('boletosAvulsos.pdf');
    }

    public function store(Request $request){
        $valor_multa = $request->multa;
        $xmlBoletoController = new XMLCoderController();
        $empresa = Empresa::where('cpf_cnpj', $request->cpf_cnpj)->first();

        if(!is_null($request->mensagem_compensacao)){
            $mensagem_compensacao = $request->mensagem_compensacao;
        }
        else{
            return redirect()->route('boletosAvulsos.index')->withErrors(['erro' => 'Ocorreu um erro com a mensagem de compensação.']);
        }

        if(is_null($empresa)){
            $user = User::where('email', 'ilike', $request->email_empresa)->first();

            if($user) {
                $empresa = $this->criar_nova_empresa($request, $user);
            } else {
                $empresa = $this->criar_user_padrao($request);
            }
        }

        try {
            $boleto = $xmlBoletoController->gerarIncluirBoletoMulta($empresa, $valor_multa, $mensagem_compensacao);
            $xmlBoletoController->incluirBoletoAvulsoRemessa($boleto);
            $multa = BoletoAvulso::where('id', $boleto->id)->first();
            return redirect()->away($multa->URL);
        } catch (ErrorRemessaException $e) {
            throw new ErrorRemessaException($this->formatarMensagem($e->getMessage()));
        }

    }

    public function buscarEmpresa(Request $request) {
        $empresa = Empresa::where('cpf_cnpj', $request->cpf_cnpj)->first();
        if($empresa){
            $endereco = $empresa->endereco;
            $telefone = $empresa->telefone;
            return json_encode([$empresa, $endereco, $telefone]);
        }
        
        return json_encode('inexistente');
    }

    private function formatarMensagem(string $mensagem)
    {
        if (auth()->user()->role == User::ROLE_ENUM['secretario']) {
            return 'WEBSERVICE ERROR: ' . $mensagem;
        }
        $mensagem_formatada = '';
        $mensagem_lower = strtolower($mensagem);
        $numeros_parenteses = '1234567890()';
        for ($i = 0; $i < strlen($mensagem_lower); $i++) {
            if (! (strpos($numeros_parenteses, $mensagem_lower[$i]))) {
                $mensagem_formatada .= $mensagem_lower[$i];
            }
        }

        return ucfirst($mensagem_formatada);
    }

    public function criar_nova_empresa(Request $request, User $user) {
        $nova_empresa = new Empresa();
        $novo_endereco = new Endereco();
        $novo_telefone = new Telefone();
        
        $novo_endereco->rua = $request->rua_da_empresa;
        $novo_endereco->numero = $request->numero_da_empresa;
        $novo_endereco->bairro = $request->bairro_da_empresa;
        $novo_endereco->cidade = $request->cidade_da_empresa;
        $novo_endereco->estado = $request->estado_da_empresa;
        $novo_endereco->cep = $request->cep_da_empresa;
        
        $novo_telefone->numero = $request->celular_da_empresa;
        
        $nova_empresa->nome = $request->nome_da_empresa;
        $nova_empresa->cpf_cnpj = $request->cpf_cnpj;

        if(strlen($request->cpf_cnpj) > 14){
            $nova_empresa->eh_cnpj = true;
        }
        else {
            $nova_empresa->eh_cnpj = false;
        }
        
        try {
            $novo_endereco->save();
            $novo_telefone->save();

            $nova_empresa->user_id = $user->id;
            $nova_empresa->endereco_id = $novo_endereco->id;
            $nova_empresa->telefone_id = $novo_telefone->id;
            $nova_empresa->save();   
        }
        catch(ErrorBoletoAvulsoException $e){
            if(!(is_null($novo_endereco->id))){
                $novo_endereco->delete();
            }
            if(!(is_null($novo_telefone->id))){
                $novo_telefone->delete();
            }

            throw new ErrorRemessaException($this->formatarMensagem($e->getMessage()));
        }

        return $nova_empresa; 
    }

    public function criar_user_padrao(Request $request){
        
        $novo_user = new User();
        $nova_empresa = new Empresa();
        $novo_endereco = new Endereco();
        $novo_telefone = new Telefone();
        $novo_requerente = new Requerente();
        
        $novo_user->name = "Empresario";
        $novo_user->email = $request->email_empresa;
        $senha_random = Str::random(8);
        $novo_user->password = bcrypt($senha_random);
        $novo_user->role = 1;
        
        $novo_endereco->rua = $request->rua_da_empresa;
        $novo_endereco->numero = $request->numero_da_empresa;
        $novo_endereco->bairro = $request->bairro_da_empresa;
        $novo_endereco->cidade = $request->cidade_da_empresa;
        $novo_endereco->estado = $request->estado_da_empresa;
        $novo_endereco->cep = $request->cep_da_empresa;
        
        $novo_telefone->numero = $request->celular_da_empresa;
        
        $nova_empresa->nome = $request->nome_da_empresa;
        $nova_empresa->cpf_cnpj = $request->cpf_cnpj;
        if(strlen($request->cpf_cnpj) > 14){
            $nova_empresa->eh_cnpj = true;
        }
        else {
            $nova_empresa->eh_cnpj = false;
        }
        
        try {
            $novo_user->save();
            $novo_endereco->save();
            $novo_telefone->save();

            $novo_requerente->cpf = '000.000.000-00';
            $novo_requerente->rg = '00000000';
            $novo_requerente->orgao_emissor = 'SDS';
            $novo_requerente->user_id = $novo_user->id;
            $novo_requerente->telefone_id = $novo_telefone->id;
            $novo_requerente->endereco_id = $novo_endereco->id;
            $novo_requerente->save();

            $nova_empresa->user_id = $novo_user->id;
            $nova_empresa->endereco_id = $novo_endereco->id;
            $nova_empresa->telefone_id = $novo_telefone->id;
            $nova_empresa->save();   
        }
        catch(ErrorBoletoAvulsoException $e){
            if(!(is_null($novo_user->id))){
                $novo_user->delete();
            }
            if(!(is_null($novo_endereco->id))){
                $novo_endereco->delete();
            }
            if(!(is_null($novo_endereco->id))){
                $novo_endereco->delete();
            }

            throw new ErrorRemessaException($this->formatarMensagem($e->getMessage()));
        }

        Mail::to($novo_user->email)->send(new CriacaoUsuarioPadrao($novo_user, $senha_random));

        return $nova_empresa;
    }
}
