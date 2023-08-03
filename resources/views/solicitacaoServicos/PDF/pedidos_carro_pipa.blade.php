<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: lightgray;
        }
    </style>
</head>
<body>
    <h1>ORDEM DE SERVIÇOS - CARROS PIPAS</h1>
    <table>
        <tr>
            <th>COD</th>
            <th>Motorista</th>
            <th>Nome (Apelido)</th>
            <th>Endereço/Referência</th>
            <th>Contato</th>
            <th>Solicitante</th>
            <th>Data Recebimento</th>
        </tr>
        @foreach ($solicitacao_servicos as $solicitacao_servico)
            <tr>
                <td>{{ $solicitacao_servico->id }}</td>
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
