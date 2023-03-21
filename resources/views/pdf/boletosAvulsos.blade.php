<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boletos</title>
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
        <h5>Relatório dos boletos de multas</h5>
        @if($filtro != null && $filtro == 'vencimento')
            <h5>Apuração por data de vencimento de @if($dataDe != null){{date('d/m/Y H:i', strtotime($dataDe))}} @else -/-/- @endif até @if($dataAte != null){{date('d/m/Y H:i', strtotime($dataAte))}}@else -/-/- @endif</h5>
        @else
            <h5>Apuração por data de criação de @if($dataDe != null){{date('d/m/Y H:i', strtotime($dataDe))}} @else -/-/- @endif até @if($dataAte != null){{date('d/m/Y H:i', strtotime($dataAte))}}@else -/-/- @endif</h5>
        @endif
    </div>
    <hr class="line-title">
    <h4>Boletos pendentes</h4>
    @php
        $total = 0;
    @endphp
    @if ($pendentes->count() > 0)
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th scope="col">Data de criação</th>
                        <th scope="col">Data de vencimento</th>
                        <th scope="col">Empresa/Serviço</th>
                        <th scope="col">Valor R$</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendentes as $i => $boleto)
                        @php
                            $total += $boleto->valor_boleto;
                        @endphp
                        <tr>
                            <th>{{$i+1}}</th>
                            <td>{{date('d/m/Y', strtotime($boleto->created_at))}}</td>
                            <td>{{date('d/m/Y', strtotime($boleto->data_vencimento))}}</td>
                            <td>{{$boleto->empresa->nome}}</td>
                            <td>{{$boleto->valor_boleto}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align: right">
                Valor total: <strong>R${{number_format($total, 2, ',', '.')}}</strong>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                Nenhum boleto pendente no período informado.
            </div>
        </div>
    @endif
    <br/><div class="quebrar_pagina"></div>
    <hr class="line-title">
    <h4>Boletos pagos</h4>
    @php
        $total = 0;
    @endphp
    @if ($pagos->count() > 0)
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th scope="col">Data de criação</th>
                        <th scope="col">Data de vencimento</th>
                        <th scope="col">Data do pagamento</th>
                        <th scope="col">Empresa/Serviço</th>
                        <th scope="col">Valor R$</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $i => $boleto)
                        @php
                            $total += $boleto->valor_boleto;
                        @endphp
                        <tr>
                            <th>{{$i+1}}</th>
                            <td>{{date('d/m/Y', strtotime($boleto->created_at))}}</td>
                            <td>{{date('d/m/Y', strtotime($boleto->data_vencimento))}}</td>
                            <td>@if($boleto->data_pagamento) {{date('d/m/Y', strtotime($boleto->data_pagamento))}} @endif</td>
                            <td>{{$boleto->empresa->nome}}</td>
                            <td>{{$boleto->valor_boleto}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align: right">
                Valor total: <strong>R${{number_format($total, 2, ',', '.')}}</strong>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                Nenhum boleto pago no período informado.
            </div>
        </div>
    @endif
    <br/><div class="quebrar_pagina"></div>
    <hr class="line-title">
    <h4>Boletos vencidos</h4>
    @php
        $total = 0;
    @endphp
    @if ($vencidos->count() > 0)
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th scope="col">Data de criação</th>
                        <th scope="col">Data de vencimento</th>
                        <th scope="col">Empresa/Serviço</th>
                        <th scope="col">Valor R$</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vencidos as $i => $boleto)
                        @php
                            $total += $boleto->valor_boleto;
                        @endphp
                        <tr>
                            <th>{{$i+1}}</th>
                            <td>{{date('d/m/Y', strtotime($boleto->created_at))}}</td>
                            <td>{{date('d/m/Y', strtotime($boleto->data_vencimento))}}</td>
                            <td>{{$boleto->empresa->nome}}</td>
                            <td>{{$boleto->valor_boleto}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align: right">
                Valor total: <strong>R${{number_format($total, 2, ',', '.')}}</strong>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                Nenhum boleto vencido no período informado.
            </div>
        </div>
    @endif
    <br/><div class="quebrar_pagina"></div>
    <hr class="line-title">
    <h4>Boletos cancelados</h4>
    @php
        $total = 0;
    @endphp
    @if ($cancelados->count() > 0)
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th scope="col">Data de criação</th>
                        <th scope="col">Data de vencimento</th>
                        <th scope="col">Empresa/Serviço</th>
                        <th scope="col">Valor R$</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cancelados as $i => $boleto)
                        @php
                            $total += $boleto->valor_boleto;
                        @endphp
                        <tr>
                            <th>{{$i+1}}</th>
                            <td>{{date('d/m/Y', strtotime($boleto->created_at))}}</td>
                            <td>{{date('d/m/Y', strtotime($boleto->data_vencimento))}}</td>
                            <td>{{$boleto->empresa->nome}}</td>
                            <td>{{$boleto->valor_boleto}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align: right">
                Valor total: <strong>R${{number_format($total, 2, ',', '.')}}</strong>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                Nenhum boleto cancelado no período informado.
            </div>
        </div>
    @endif
</body>
</html>
