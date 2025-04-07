<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background-color: #e9ecef;
        }

        .header {
            background-color: #006335;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table {
            font-size: 9px;
        }

        .table td,
        .table th {
            padding: 0.35rem;
        }

        .table thead th {
            background-color: #006335;
            color: white;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 12px;
            color: #f8f9fa;
        }

        h2 {
            font-size: 16px;
            margin-bottom: 12px;
            color: #343a40;
        }

        h3 {
            font-size: 14px;
            margin-bottom: 15px;
        }

        h4 {
            font-size: 10px;
            margin-bottom: 7px;
        }

        .signature-line {
            width: 180px;
            border-bottom: 1px solid #000;
            display: inline-block;
        }

        .signature-line2 {
            width: 90px;
            border-bottom: 1px solid #000;
            display: inline-block;
        }

        .signature-section {
            margin-top: 25px;
            text-align: center;
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .d-flex h4 {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>SECRETARIA DE DESENVOLVIMENTO RURAL E MEIO AMBIENTE</h1>
    </div>

    <div class="container">
        <h2 class="text-center">Ordem de Serviços | Carros Pipas</h2>

        <div class="row justify-content-center">
            <div class="text-center">
                <h4>
                    Motorista/Apelido: {{ $motorista->motorista }}/{{ $motorista->nome_apelido }}
                    Placa: <span class="signature-line2"></span>
                    Data: {{ date('d/m/Y', strtotime($data)) }}
                </h4>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">COD</th>
                        <th scope="col">Endereço/Referência</th>
                        <th scope="col">Contato</th>
                        <th scope="col">Solicitante</th>
                        <th scope="col">Data Recebimento</th>
                        <th scope="col">Assinatura do Recebedor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitacao_servicos as $solicitacao_servico)
                        <tr>
                            <td>{{ $solicitacao_servico->beneficiario->codigo }}</td>
                            <td>{{ $solicitacao_servico->beneficiario->Endereco->distrito }},
                                {{ $solicitacao_servico->beneficiario->Endereco->comunidade }},
                                {{ $solicitacao_servico->beneficiario->Endereco->numero }} -
                                {{ $solicitacao_servico->beneficiario->Endereco->cidade }}-{{ $solicitacao_servico->beneficiario->endereco->estado }}
                            </td>
                            <td>{{ $solicitacao_servico->beneficiario->telefone->numero }}</td>
                            <td>{{ $solicitacao_servico->beneficiario->nome }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container signature-section mt-4">
        <div><span class="signature-line"></span></div>
        <div>
            <h4>ASSINATURA DO RESPONSÁVEL</h4>
        </div>
        <div>
            <h4>Setor de Desenvolvimento Rural e Meio Ambiente</h4>
        </div>
    </div>
</body>

</html>
