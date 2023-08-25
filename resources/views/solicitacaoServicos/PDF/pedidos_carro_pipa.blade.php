<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 15px;
            font-size: 10px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #d3d3d3;
        }
        .table-container {
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        h3 {
            font-size: 16px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SECRETARIA DE DESENVOLVIMENTO RURAL E MEIO AMBIENTE</h1>
    </div>

    <div class="container">
        <h1 class="text-center">Ordem de Serviços - Carros Pipas</h1>
        <h3 class="text-center">Motorista/Apelido: {{ $motorista->motorista }}/{{$motorista->nome_apelido}}, Placa: </h3>
        
    </div>

    <div class="container table-container">
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">COD</th>
                    <th scope="col">Endereço/Referência</th>
                    <th scope="col">Contato</th>
                    <th scope="col">Solicitante</th>
                    <th scope="col">Data Recebimento</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($solicitacao_servicos as $solicitacao_servico)
                    <tr>
                        <td>{{ $solicitacao_servico->beneficiario->codigo }}</td>
                        <td>{{ $solicitacao_servico->beneficiario->endereco->rua}}, {{ $solicitacao_servico->beneficiario->endereco->numero }} - {{ $solicitacao_servico->beneficiario->endereco->bairro }} - {{ $solicitacao_servico->beneficiario->endereco->cidade }}/{{ $solicitacao_servico->beneficiario->endereco->uf }}</td>
                        <td>{{ $solicitacao_servico->beneficiario->telefone->numero }}</td>
                        <td>{{ $solicitacao_servico->beneficiario->nome }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
