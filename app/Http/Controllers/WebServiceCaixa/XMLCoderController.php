<?php

namespace App\Http\Controllers\WebServiceCaixa;

use App\Http\Controllers\Controller;
use App\Models\WebServiceCaixa\Pessoa;
use App\Models\WebServiceCaixa\IncluirBoletoRemessa;
use App\Models\WebServiceCaixa\ConsultarBoletoRemessa;
use App\Models\BoletoCobranca;
use App\Models\Requerimento;
use Illuminate\Http\Request;

class XMLCoderController extends Controller
{
    public function gerar_incluir_boleto(Requerimento $requerimento)
    {
        $pagador = new Pessoa();
        $pagador->gerar_pagador($requerimento->empresa);

        $beneficiario = new Pessoa;
        $beneficiario->gerar_beneficiario();

        $boleto = new IncluirBoletoRemessa();
        $data_vencimento = now()->addDays(3)->format('Y-m-d');
        $boleto->setAttributes([
            'codigo_beneficiario' => $beneficiario->cod_beneficiario,
            'nosso_numero' => '14000000000002169',
            'data_vencimento' => $data_vencimento,
            'valor' => 40.50,
            'pagador' => $pagador,
            'beneficiario' => $beneficiario,
        ]);

        $boleto->data_vencimento = $data_vencimento;
        $boleto->requerimento_id = $requerimento->id;
        $boleto->save();
        $boleto->salvar_arquivo($boleto->gerar_remessa(), $requerimento);
        $boleto->update();

        return $boleto;
    }

    public function enviar_remessa(BoletoCobranca $boleto)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://barramento.caixa.gov.br/sibar/ManutencaoCobrancaBancaria/Boleto/Externo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_CIPHER_LIST => 'DEFAULT@SECLEVEL=1',
            CURLOPT_POSTFIELDS => file_get_contents(storage_path('').'/app/'.$boleto->caminho_arquivo_remessa),
            CURLOPT_HTTPHEADER => array(
                'SoapAction: INCLUI_BOLETO',
                'Content-Type: text/plain'
            ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        // dd($response);
    }

    public function consultar_remessa(BoletoCobranca $boleto)
    {
        $remessa = new ConsultarBoletoRemessa();

        
    }

    public function teste(Request $request) {
        return view('teste');
    }

    public function ler_xml(Request $request) {
        $boleto = new IncluirBoletoRemessa();
        $array_resposta = $boleto->to_array(file_get_contents($request->file));
        dd($array_resposta);
    }
}
