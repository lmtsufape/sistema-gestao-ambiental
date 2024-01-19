<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprovante de Cadastro de Feirantes, Ambulantes, Traillers e Food Trucks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <style>
        .linha {
            border-bottom: 2px solid rgb(0, 0, 0);
            display: block;
        }

        .centralizar {
            text-align: center;
        }

        .row {
            margin-top: 10px;
        }

        td {
            border: 1px solid #000000;
        }

        h5, h6, p {
            font-size: 16px;
            padding-left: 5px;
            margin-bottom: 5px;
        }

        .rodape {
            font-size: 14.5px;
            font-weight: bold;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
</head>
<body>
<div class="centralizar">
    <img src="{{public_path('img/garanhuns.png')}}" width="58px" height="80px">
    <h6 style="font-size: 16px; padding-top: 20px"> <strong> PREFEITURA MUNICIPAL DE GARANHUNS </strong> </h6>
    <div class="linha"></div>
    <h6 style="font-size: 16px; padding-top: 10px"> <strong> SECRETARIA MUNICIPAL DE DESENVOLVIMENTO RURAL E MEIO AMBIENTE (SDRMA) </strong> </h6>
    <h6 style="font-size: 16px"> <strong> DIRETORIA DE ABASTECIMENTO </strong> </h6>
</div>

<br>
<br>
<br>
<br>
<br>
<br>

<div class="row">
    <table style="border-collapse: collapse;
            width: 100%;
            border: 1px solid #000000;
            border-style: solid;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 0">
        <tr>
            <td colspan="10" style="text-align: center">
                <h5> <strong> Comprovante de Cadastro de Feirantes, Ambulantes, Traillers e Food Trucks </strong> </h5>
            </td>
        </tr>

        <tr>
            <td colspan="10" style="text-align: center">
                <h5>Data do Cadastro: {{$data_cadastro}}</h5>
            </td>
        </tr>
        <tr>
            <td colspan="10" style="padding-top: 20px"></td>
        </tr>
        <tr>
            <td colspan="10"><p><strong>1 – Nome</strong><br>{{mb_strtoupper($feirante->nome)}}</p></td>
        </tr>
        <tr>
            <td colspan="4"><p><strong>2 – CPF</strong><br>{{$feirante->cpf}}</p></td>
            <td colspan="3"><p><strong>3 – RG</strong><br>{{$feirante->rg}}</p></td>
            <td colspan="3"><p><strong>4 – Telefone</strong><br>{{$feirante->telefone->numero}}</p></td>
        </tr>
        <tr>
            <td colspan="8"><p><strong>5 – Endereço do Comércio</strong><br>{{$endereco_comercio->enderecoSimplificado()}}</p></td>
            <td colspan="2"><p><strong>6 – CEP</strong><br>{{$endereco_comercio->cep}}</p></td>
        </tr>
        <tr>
            <td colspan="10"><p><strong>7 – Atividade Comercial</strong><br>{{ $feirante->atividade_comercial }}</p></td>
        </tr>
        <tr>
            <td colspan="10"><p><strong>8 – Resíduos Gerados</strong><br>{{ $feirante->residuos_gerados }}</p></td>
        </tr>
    </table>
</div>
<div class="text-center" style="position: absolute; bottom: 0px;">
    <div class="linha"></div>
    <div>
        <p class="rodape">Centro Administrativo II – Secretaria Municipal de Desenvolvimento Rural e Meio Ambiente (SDRMA)</p>
        <p class="rodape">Av. Irga, 100, Heliópolis – Garanhuns CEP: 55.297-320</p>
        <p class="rodape">WhatsApp: 3762-7086 | E-mail: meioambientegaranhuns@gmail.com</p>
    </div>
</div>
</body>
</html>
