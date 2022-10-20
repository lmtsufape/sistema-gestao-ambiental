<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Protocolo do requerimento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        .linha{
            border-bottom: 2px solid rgb(0, 0, 0);
            display: block;
        }
        .line-title{
            border-style: inset;
            border-top: 1px solid #000;
            width: 100%;
        }
        .line-title-2{
            border-style: inset;
            border-top: 1px solid #d1d1d1;
            width: 100%;
            margin-top: -50px;
        }
        .line-title-3{
            border-style: inset;
            border-top: 1px solid #d1d1d1;
            width: 100%;
            margin-top: -10px;
        }
        .centralizar {
            text-align: center;
        }
        .row {
            margin-top: 10px;
        }
        .quebrar_pagina {
            page-break-after: always;
        }
        td {
            border: 1px solid #000000;
        }
        h5 {
            padding-left: 5px;
            margin-bottom: 0px;
        }
        p {
            font-size: 12px;
            padding-left: 5px;
            margin-bottom: 0px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</head>
<body>
    <div class="centralizar">
        <img src="{{public_path('img/garanhuns.png')}}" width="58px" height="80px">
        <h6 style="font-size: 14px; padding-top: 20px">PREFEITURA MUNICIPAL DE GARANHUNS</h6>
        <div class="linha">
        </div>
        <h6 style="font-size: 14px; padding-top: 10px">SECRETARIA MUNICIPAL DE DESENVOLVIMENTO RURAL E MEIO AMBIENTE (SDRMA)</h6>
        <h6 style="font-size: 14px">DEPARTAMENTO DE MEIO AMBIENTE E FISCALIZAÇÃO AMBIENTAL</h6>
        <h6 style="font-size: 14px">DIVISÃO DE LICENCIAMENTO E FISCALIZAÇÃO</h6>
    </div>
        <div class="row">
            <table style="border-collapse: collapse;
            width: 100%;
            border: 1px solid #000000;
            border-style: solid;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 0">
                <tbody>
                    <tr>
                        <td style="
                        text-align: center" colspan="10">
                        <h5>Comprovante de Requerimento de Licenciamento Ambiental</h5>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5"><h5>Protocolo: {{$requerimento->protocolo}}</h5>
                        </td>
                        <td colspan="5"><h5>DATA DO REQUERIMENTO: {{date('d/m/Y', strtotime($requerimento->created_at))}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="10" style="padding-top: 20px"></td>
                    </tr>
                    <tr>
                        <td colspan="3"><p><strong>1 – Empreendimento</strong><br>{{mb_strtoupper($requerimento->empresa->cnaes->first()->setor->nome, 'UTF-8')}}</p></td>
                        <td colspan="4"><p><strong>2 – Razão Social</strong><br>{{$requerimento->empresa->nome}}</p></td>
                        <td colspan="3"><p><strong>3 – Nome Fantasia</strong><br>***********</p></td>
                    </tr>
                    <tr>
                        <td colspan="3"><p><strong>4 – CNPJ/CPF</strong><br>{{$requerimento->empresa->cpf_cnpj}}</p></td>
                        <td colspan="4"><p><strong>5 – Endereço</strong><br>{{$requerimento->empresa->endereco->enderecoSimplificado()}}</p></td>
                        <td colspan="3"><p><strong>6 – CEP</strong><br>{{$requerimento->empresa->endereco->cep}}</p></td>
                    </tr>
                    <tr>
                        <td colspan="3"><p><strong>7 – Telefone</strong><br>{{$requerimento->empresa->telefone->numero}}</p></td>
                        <td colspan="4"><p><strong>8 – Tipo de Solicitação</strong><br>{{$requerimento->protocoloTipoDeLicenca()}}</p></td>
                        <td colspan="3"><p><strong>9 – RG/Inscrição Estadual</strong><br></p></td>
                    </tr>
                    <tr>
                        <td colspan="10"><p><strong>10 – Tipologia</strong><br>
                            O empreendimento enquadra-se na Tipologia de {{mb_strtoupper($requerimento->empresa->cnaes->first()->setor->nome, 'UTF-8')}}, do anexo I da Lei Municipal Nº 4.224/2015, porte {{mb_strtoupper($requerimento->empresa->porte(), 'UTF-8')}} e potencial poluidor {{mb_strtoupper($requerimento->empresa->potencialPoluidor(), 'UTF-8')}}, localizada na {{$requerimento->empresa->endereco->enderecoSimplificado()}}, GARANHUNS/PE
                        </p></td>
                    </tr>
                    <tr>
                        <td colspan="10"><p><strong>11 – Observações: <br>
                           </strong>
                        </p></td>
                    </tr>
                    <tr>
                        <td style="text-align: center" colspan="10"><p><strong>12 – Documentos Apresentados a SDRMA: <br>
                           </strong>
                        </p></td>
                    </tr>
                    @foreach ($requerimento->documentos as $i => $documento)
                        @if($i+1 == $requerimento->documentos->count() && $i%2 == 0)
                            <tr>
                                <td colspan="10"><p>{{$documento->nome}}</p></td>
                            </tr>
                        @else
                            @if ($i%2 == 0)
                                <tr>
                            @endif

                            <td colspan="5"><p>{{$documento->nome}}</p></td>

                            @if ($i%2 != 0)
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="10"><p style="padding-bottom: 100px"><strong>13 – Funcionário (SDRMA): <br>
                           </strong>
                        </p></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <div style="position: absolute; bottom: 0px; margin-left:80px;">
        <div class="linha"></div>
        <div class="centralizar">
            <p>Centro Administrativo II – Secretaria Municipal de Desenvolvimento Rural e Meio Ambiente (SDRMA)</p>
            <p>Av. Irga, 100, Heliópolis – Garanhuns CEP: 55.297-320</p>
            <p>whatsapp: 3762-7086</p>
            <p>e-mail: meioambientegaranhuns@gmail.com</p>
        </div>
    </div>
</body>
</html>
