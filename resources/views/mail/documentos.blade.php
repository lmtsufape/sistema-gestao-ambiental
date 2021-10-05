<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <p style="color: black; font-family: 'Times New Roman', Times, serif;"> 
        O status de seu requerimento nº {{$requerimento->id}} foi alterado para documentos requeridos. Segue a lista de documentos para o andamento do processo
    </p>
    <ul style="color: black; font-family: 'Times New Roman', Times, serif;">
        @foreach ($documentos as $documento)
            <li>{{$documento->nome}}</li>
        @endforeach
    </ul>
    <br>
    <p style="'Times New Roman', Times, serif; font-size: 12px;">
        Atenciosamente, <br>
        {{ config('app.name') }} <br>
        Laboratório Multidisciplinar de Tecnologias Sociais<br>
        Universidade Federal do Agreste de Pernambuco
    </p>
</body>
</html>