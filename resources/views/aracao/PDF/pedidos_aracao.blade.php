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
    <h1>CONTROLE DE ARAÇÃO DE TERRAS 2023</h1>
    <table>
        <tr>
            <th>COD</th>
            <th>Nome (Apelido)</th>
            <th>CPF</th>
            <th>RG</th>
            <th>Endereço/Referência</th>
            <th>Telefone</th>
            <th>Cultura</th>
            <th>Ponto de Localização</th>
            <th>Quantidade de Ha</th>
            <th>Quantidade de Horas</th>
        </tr>
        @foreach ($aracaos as $aracao)
            <tr>
                <td>{{ $aracao->id }}</td>
                <td>{{ $aracao->beneficiario->nome }}</td>
                <td>{{ $aracao->beneficiario->cpf }}</td>
                <td>{{ $aracao->beneficiario->rg }}</td>
                <td>{{ $aracao->beneficiario->endereco->rua}}, {{ $solicitacao_servico->beneficiario->endereco->numero }} - {{ $solicitacao_servico->beneficiario->endereco->bairro }} - {{ $solicitacao_servico->beneficiario->endereco->cidade }}/{{ $solicitacao_servico->beneficiario->endereco->uf }}</td>
                <td>{{ $aracao->beneficiario->telefone->numero }}</td>
                <td>{{ $aracao->cultura }}</td>
                <td>{{ $aracao->ponto_localizacao }}</td>
                <td>{{ $aracao->quantidade_ha }}</td>
                <td>{{ $aracao->quantidade_horas }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
