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
            'nosso_numero' => '14202101696260000',
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
        // dd(storage_path('').'/app/'.$boleto->caminho_arquivo_remessa);
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => env('URL_API_WEB_SERVICE'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                "file" => curl_file_create(storage_path('').'/app/'.$boleto->caminho_arquivo_remessa, "xml"),
            ]
        ]);
        
        $response = curl_exec($curl);
        
        curl_close($curl);

        dd($response);
    }

    public function consultar_remessa(BoletoCobranca $boleto)
    {
        $remessa = new ConsultarBoletoRemessa();

        
    }

    public function teste(Request $request) {
        dd($request);
    }
}
