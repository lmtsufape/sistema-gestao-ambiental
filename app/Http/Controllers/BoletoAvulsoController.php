<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Telefone;
use App\Models\User;
use App\Models\BoletoAvulso;
use App\Http\Controllers\BoletoAvulsoController;
use App\Mail\CriacaoUsuarioPadrao;
use App\Http\Controllers\WebServiceCaixa\XMLCoderController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class BoletoAvulsoController extends Controller
{
    public function index() {
        return view('boletosAvulsos.index');
    }

    public function store(Request $request){
        $valor_multa = $request->multa;
        $xmlBoletoController = new XMLCoderController();
        $empresa = Empresa::where('cpf_cnpj', $request->cpf_cnpj)->first();

        if(is_null($empresa)){
            $empresa = $this->criar_user_padrao($request);
        }

        try {
            $boleto = $xmlBoletoController->gerarIncluirBoletoMulta($empresa, $valor_multa);
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

    public function criar_user_padrao(Request $request){
        
        $novo_user = new User();
        $nova_empresa = new Empresa();
        $novo_endereco = new Endereco();
        $novo_telefone = new Telefone();
        
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
