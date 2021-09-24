<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <p style="color: black; font-family: 'Times New Roman', Times, serif;"> 
        O status do requerimento nº {{$requerimento->id}} foi alterado para documentos enviados. Por favor analise os documentos e dê seguimento ao processo.
    </p>
    <br>
    <p style="'Times New Roman', Times, serif; font-size: 12px;">
        Atenciosamente, <br>
        {{ config('app.name') }} <br>
        Laboratório Multidisciplinar de Tecnologias Sociais<br>
        Universidade Federal do Agreste de Pernambuco
    </p>
</body>
</html>