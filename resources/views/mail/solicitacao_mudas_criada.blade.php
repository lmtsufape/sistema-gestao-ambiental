<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A solicitação de mudas foi recebida com sucesso. Segue o protocolo gerado. {{$solicitacao->protocolo}}
    </p>

    <p style="'Times New Roman', Times, serif; font-size: 12px;">
        Atenciosamente, <br>
        {{ config('app.name') }} <br>
        Laboratório Multidisciplinar de Tecnologias Sociais<br>
        Universidade Federal do Agreste de Pernambuco
    </p>
</body>
</html>
