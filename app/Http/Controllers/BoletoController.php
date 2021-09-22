<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as DomPDF;
use Eduardokum\LaravelBoleto\Pessoa;
use Eduardokum\LaravelBoleto\Boleto\Banco\Caixa;
use Eduardokum\LaravelBoleto\Boleto\Render\Pdf;
use App\Models\Requerimento;
use App\Models\Empresa;
use App\Models\BoletoCobranca;
use Illuminate\Support\Facades\Storage;
use DateTime;
use DateInterval;

class BoletoController extends Controller
{
    /**
     * Cria um boleto para o requerimento.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $requerimento = Requerimento::find($id);
        $boleto = $requerimento->boleto;
        if (is_null($boleto)) {
            $boleto = $this->gerarBoleto($requerimento);
            return $this->exibirBoleto($boleto);
        } else {
            if (now() >= $boleto->data_vencimento) {
                $this->gerarNovoBoleto($boleto);
                return $this->exibirBoleto($boleto);
            } else {
                return $this->exibirBoleto($boleto);
            }
        }
    }

    /**
     * Gera um boleto para um requerimento
     *
     * @param  App\Models\Requerimento
     * @return App\Models\BoletoCobranca
     */
    private function gerarBoleto(Requerimento $requerimento)
    {
        $empresa = $requerimento->empresa;
        $pagador = $this->getPagador($empresa);
        $beneficiario = $this->getBeneficiario();
        $boletoCaixa = $this->getBoletoCaixa($requerimento, $pagador, $beneficiario);
        $boletoCobranca = $this->salvarBoletoCaixa($boletoCaixa, $requerimento);
        return $boletoCobranca;
    }

    /**
     * Gera um novo boleto com uma nova data para um boleto antigo passado.
     *
     * @param  App\Models\BoletoCobranca $boleto
     * @return void
     */
    private function gerarNovoBoleto(BoletoCobranca $boleto)
    {  
        $requerimento = $boleto->requerimento;
        $empresa = $boleto->requerimento->empresa;
        $pagador = $this->getPagador($empresa);
        $beneficiario = $this->getBeneficiario();
        $boletoCaixa = $this->getBoletoCaixa($requerimento, $pagador, $beneficiario);
        $this->editarBoletoCaixa($boleto, $boletoCaixa);
    }

    /**
     * Cria o pagador do boleto.
     *
     * @param  App\Models\Empresa
     * @return Eduardokum\LaravelBoleto\Pessoa
     */
    private function getPagador(Empresa $empresa)
    {
        $pagador = new Pessoa([
            'documento' => $empresa->cnpj,
            'nome'      => $empresa->nome,
            'cep'       => $empresa->endereco->cep,
            'endereco'  => $empresa->endereco->rua . ', ' . $empresa->endereco->numero,
            'bairro'    => $empresa->endereco->bairro,
            'uf'        => $empresa->endereco->estado,
            'cidade'    => $empresa->endereco->cidade,
        ]);

        return $pagador;
    }

    /**
     * Cria o beneficiario do boleto.
     *
     * @return Eduardokum\LaravelBoleto\Pessoa
     */
    private function getBeneficiario()
    {
        $beneficiario = new Pessoa([
            'documento' => env('CNPJ_EMPRESA_BENEFICIADA'),
            'nome'      => env('NOME_EMPRESA_BENEFICIADA'),
            'cep'       => env('CEP_EMPRESA_BENEFICIADA'),
            'endereco'  => env('ENDERECO_EMPRESA_BENEFICIADA') . ', ' . env('NUMERO_EMPRESA_BENEFICIADA'),
            'bairro'    => env('BAIRRO_EMPRESA_BENEFICIADA'),
            'uf'        => env('UF_EMPRESA_BENEFICIADA'),
            'cidade'    => env('CIDADE_EMPRESA_BENEFICIADA'),
        ]);

        return $beneficiario;
    }

    /**
     * Seta os dados do boleto.
     *
     * @param  App\Models\Requerimento
     * @param  Eduardokum\LaravelBoleto\Pessoa $pagador
     * @param  Eduardokum\LaravelBoleto\Pessoa $beneficiario
     * @return Eduardokum\LaravelBoleto\Boleto\Banco\Caixa
     */
    private function getBoletoCaixa(Requerimento $requerimento, Pessoa $pagador, Pessoa $beneficiario) 
    {
        $quant_boletos = BoletoCobranca::count();
        $dataVencimento = $this->gerarDataVencimento();
        $caixa = new Caixa([
            'logo' => storage_path('app'. DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'logos' . DIRECTORY_SEPARATOR .'caixa.png'),
            'dataVencimento' => $dataVencimento,
            'valor' => $requerimento->valor,
            'numero' => $quant_boletos+1,
            'numeroDocumento' => $quant_boletos+1,
            'pagador' => $pagador,
            'beneficiario' => $beneficiario,
            'carteira' => 'RG',
            'agencia' => env('CAIXA_AGENCIA'),
            'codigoCliente' => env('CAIXA_CONTA'),
            'multa' => 1, // 1% do valor do boleto após o vencimento
            'juros' => 1, // 1% ao mês do valor do boleto
            'jurosApos' => 0, // quant. de dias para começar a cobrança de juros,
            'descricaoDemonstrativo' => $this->getDemonstrativo($requerimento),
            'instrucoes' => ['Pagável em qualquer agência da caixa ou loterias caixa.'],
        ]);

        return $caixa;
    }

    /**
     * Gera a data de vencimento do boleto, pula os domingos.
     *
     * @return Carbon\Carbon
     */
    private function gerarDataVencimento()
    {
        $data = (new Carbon())->addDays(3);
        if ($data->dayOfWeek == 0) {
            $data = $data->addDays(1);
        }
        return $data;
    }

    /**
     * Gera o demonstrativo do boleto.
     * 
     * @param App\Models\Requerimento $requeirmento
     * @return array String
     */
    private function getDemonstrativo(Requerimento $requerimento)
    {
        return [
            'Pagamento da taxa referênte a ' . $requerimento->tipoString() . ' ambiental.',
        ];
    }

    /**
     * Gera o demonstrativo do boleto.
     * 
     * @param Eduardokum\LaravelBoleto\Boleto\Banco\Caixa $boleto
     * @param App\Models\Requerimento $requeirmento
     * @return App\Models\BoletoCobranca
     */
    private function salvarBoletoCaixa(Caixa $boleto, Requerimento $requerimento) 
    {
        $path = 'documentos/requerimentos/' . $requerimento->id . '/boleto.pdf';
        $boletoCobranca = new BoletoCobranca();
        $pdfFile = $boleto->renderPdf();
        Storage::put('public/'. $path, $pdfFile);

        $boletoCobranca->data_vencimento = $this->gerarDataVencimento();
        $boletoCobranca->caminho_boleto = $path;
        $boletoCobranca->requerimento_id = $requerimento->id;
        $boletoCobranca->save();

        return $boletoCobranca;
    }

    /**
     * Exibe o arquivo de um boleto passado.
     * 
     * @param App\Models\BoletoCobranca $boleto
     * @return \Illuminate\Http\Response
     */
    private function exibirBoleto(BoletoCobranca $boleto)
    {
        if (Storage::disk()->exists('public/' . $boleto->caminho_boleto)) {
            return response()->file('storage/' . $boleto->caminho_boleto);
        }

        return abort(404);
    }

    /**
     * Exibe o arquivo de um boleto passado.
     * 
     * @param App\Models\BoletoCobranca $boleto
     * @param Eduardokum\LaravelBoleto\Boleto\Banco\Caixa $boletoCaixa
     * @return void
     */
    private function editarBoletoCaixa(BoletoCobranca $boleto, Caixa $boletoCaixa)
    {
        $path = 'documentos/requerimentos/' . $boleto->requerimento->id . '/boleto.pdf';
        $pdfFile = $boletoCaixa->renderPdf();
        Storage::put('public/'. $path, $pdfFile);

        $boleto->data_vencimento = $this->gerarDataVencimento();
        $boleto->caminho_boleto = $path;
        $boleto->update();
    }
}
