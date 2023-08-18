<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 15px;
            font-size: 10px;
        }
        h1 {
            color: #444;
            text-align: center;
            border-bottom: 1px solid #444;
            padding-bottom: 5px;
            font-size: 18px;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #f9f9f9;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            font-size: 9px;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-size: 10px;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .header {
            background-color: #4CAF50;
            color: #fff;
            padding: 3px 15px;
            text-align: center;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SECRETARIA DE DESENVOLVIMENTO RURAL E MEIO AMBIENTE</h1>
    </div>

    <h1>ORDEM DE SERVIÇOS - CARROS PIPAS</h1>

    <table>
        <tr>
            <th>COD</th>
            <th>Motorista</th>
            <th>Nome (Apelido)</th>
            <th>Endereço/Referência</th>
            <th>Contato</th>
            <th>Solicitante</th>
        </tr>
        @foreach ($solicitacao_servicos as $solicitacao_servico)
            <tr>
                <td>{{ $solicitacao_servico->beneficiario->codigo }}</td>
                <td>{{ $solicitacao_servico->motorista }}</td>
                <td>{{ $solicitacao_servico->nome_apelido }}</td>
                <td>{{ $solicitacao_servico->beneficiario->endereco->rua}}, {{ $solicitacao_servico->beneficiario->endereco->numero }} - {{ $solicitacao_servico->beneficiario->endereco->bairro }} - {{ $solicitacao_servico->beneficiario->endereco->cidade }}/{{ $solicitacao_servico->beneficiario->endereco->uf }}</td>
                <td>{{ $solicitacao_servico->beneficiario->telefone->numero }}</td>
                <td>{{ $solicitacao_servico->beneficiario->nome }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
