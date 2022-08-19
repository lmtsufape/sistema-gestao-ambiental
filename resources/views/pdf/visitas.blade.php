<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Visitas do dia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
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
    </style>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</head>
<body>
    <div class="centralizar">
        <h4>Secretaria de Desenvolvimento Rural e Meio Ambiente de Garanhuns - PE</h4>
        <h5>Relatório de visitas</h5>
    </div>

    @if ($visitas->count() > 0)
        @foreach ($visitas as $i => $visita)
            <hr class="line-title">
            @if ($visita->requerimento != null)
                <div class="row">
                    <div class="col-12">
                        <strong>Requerimento ({{$visita->requerimento->tipoString() . ' - ' . $visita->requerimento->tipoDeLicenca()}})</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div>
                            <strong>Empresa/Serviço:</strong> {{$visita->requerimento->empresa->nome}}
                        </div>
                        <div>
                            <strong>CNPJ/CPF:</strong> {{$visita->requerimento->empresa->cpf_cnpj}}
                        </div>
                        <div>
                            <strong>E-mail:</strong> {{$visita->requerimento->empresa->user->email}}
                        </div>
                        <div>
                            <strong>Contato:</strong> {{$visita->requerimento->empresa->user->requerente->telefone->numero}}
                        </div>
                    </div>
                    <div class="col-6" style="margin-left: 400px;">
                        <div>
                            <strong>CEP:</strong> {{$visita->requerimento->empresa->endereco->cep}}
                        </div>
                        <div>
                            <strong>Bairro:</strong> {{$visita->requerimento->empresa->endereco->bairro}}
                        </div>
                        <div>
                            <strong>Rua:</strong> {{$visita->requerimento->empresa->endereco->rua}}
                        </div>
                        <div>
                            <strong>Complemento:</strong> {{$visita->requerimento->empresa->endereco->complemento}}
                        </div>
                    </div>
                </div>
                <hr class="line-title-2">
                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Data prevista</th>
                                <th scope="col">Data de realização</th>
                                <th scope="col">Analista</th>
                                <th scope="col">Potencial poluidor</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{date('d/m/Y', strtotime($visita->data_marcada))}}</td>
                                <td>{{$visita->data_realizada != null ? date('d/m/Y', strtotime($visita->data_realizada)) : 'Não realizada'}}</td>
                                <td>{{$visita->analista->name}}</td>
                                <td>{{$visita->requerimento->empresa->potencialPoluidor()}}</td>
                                <td>{{$visita->status()}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @elseif ($visita->denuncia != null)
                <div class="row">
                    <div class="col-12">
                        <strong>Denúncia de protocolo {{$visita->denuncia->protocolo}} ({{$visita->denuncia->empresa_id != null ? "Empresa cadastrada" : "Empresa ou pessoa não cadastrada"}})</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        @if ($visita->denuncia->empresa_id != null)
                            <div>
                                <strong>Empresa/Serviço:</strong> {{$visita->denuncia->empresa->nome}}
                            </div>
                            <div>
                                <strong>CNPJ/CPF:</strong> {{$visita->denuncia->empresa->cpf_cnpj}}
                            </div>
                            <div>
                                <strong>E-mail:</strong> {{$visita->denuncia->empresa->user->email}}
                            </div>
                            <div>
                                <strong>Contato:</strong> {{$visita->denuncia->empresa->user->requerente->telefone->numero}}
                            </div>
                        @else
                            <div>
                                <strong>Empresa/Serviço:</strong> {{$visita->denuncia->empresa_nao_cadastrada}}
                            </div>
                        @endif
                    </div>
                    <div class="col-6" style="margin-left: 400px;">
                        @if ($visita->denuncia->empresa_id != null)
                            <div>
                                <strong>CEP:</strong> {{$visita->denuncia->empresa->endereco->cep}}
                            </div>
                            <div>
                                <strong>Bairro:</strong> {{$visita->denuncia->empresa->endereco->bairro}}
                            </div>
                            <div>
                                <strong>Rua:</strong> {{$visita->denuncia->empresa->endereco->rua}}
                            </div>
                            <div>
                                <strong>Complemento:</strong> {{$visita->denuncia->empresa->endereco->complemento}}
                            </div>
                        @else
                            <div>
                                <strong>Endereço:</strong> {{$visita->denuncia->endereco}}
                            </div>
                        @endif
                    </div>
                </div>
                <hr class="line-title-3">
                <div class="row">
                    <div class="col-12">
                        <strong>Texto da denúncia:</strong>{!! $visita->denuncia->texto !!}
                    </div>
                </div>
                <hr class="line-title-3">
                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Data prevista</th>
                                <th scope="col">Data de realização</th>
                                <th scope="col">Analista</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{date('d/m/Y', strtotime($visita->data_marcada))}}</td>
                                <td>{{$visita->data_realizada != null ? date('d/m/Y', strtotime($visita->data_realizada)) : 'Não realizada'}}</td>
                                <td>{{$visita->analista->name}}</td>
                                <td>{{$visita->status()}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @elseif ($visita->solicitacaoPoda != null)
                <div class="row">
                    <div class="col-12">
                        <strong>Solicitação de poda de protocolo {{$visita->solicitacaoPoda->protocolo}}</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        @if ($visita->solicitacaoPoda->requerente != null)
                            <div>
                                <strong>Requerente:</strong> {{$visita->solicitacaoPoda->requerente->user->name}}
                            </div>
                            <div>
                                <strong>CNPJ/CPF:</strong> {{$visita->solicitacaoPoda->requerente->user->cpf_cnpj}}
                            </div>
                            <div>
                                <strong>E-mail:</strong> {{$visita->solicitacaoPoda->requerente->user->email}}
                            </div>
                            <div>
                                <strong>Contato:</strong> {{$visita->solicitacaoPoda->requerente->telefone->numero}}
                            </div>
                        @endif
                    </div>
                    <div class="col-6" style="margin-left: 400px;">
                        @if ($visita->solicitacaoPoda->endereco != null)
                            <div>
                                <strong>CEP:</strong> {{$visita->solicitacaoPoda->endereco->cep}}
                            </div>
                            <div>
                                <strong>Bairro:</strong> {{$visita->solicitacaoPoda->endereco->bairro}}
                            </div>
                            <div>
                                <strong>Rua:</strong> {{$visita->solicitacaoPoda->endereco->rua}}
                            </div>
                            <div>
                                <strong>Complemento:</strong> {{$visita->solicitacaoPoda->endereco->complemento}}
                            </div>
                        @endif
                    </div>
                </div>
                @if($visita->solicitacaoPoda->comentario != null)
                    <hr class="line-title-3">
                    <div class="row">
                        <div class="col-12">
                            <strong>Comentário: </strong>{{ $visita->solicitacaoPoda->comentario }}
                        </div>
                    </div>
                @endif
                <hr class="line-title-3">
                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Data prevista</th>
                                <th scope="col">Data de realização</th>
                                <th scope="col">Analista</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{date('d/m/Y', strtotime($visita->data_marcada))}}</td>
                                <td>{{$visita->data_realizada != null ? date('d/m/Y', strtotime($visita->data_realizada)) : 'Não realizada'}}</td>
                                <td>{{$visita->analista->name}}</td>
                                <td>{{$visita->status()}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
            @if ($i != $visitas->count() - 1 && $i % 2 == 1)
                <br/><div class="quebrar_pagina"></div>
            @endif
        @endforeach
    @else
        <div class="row">
            <div class="col-md-12">
                Nenhuma visita programada para hoje.
            </div>
        </div>
    @endif
</body>
</html>
