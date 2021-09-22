<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contato</title>
</head>
<body>
    <p>
        Nome completo: {{$dados->nome_completo}}
    </p>
    <p>
        E-mail para contato: {{$dados->email}}
    </p>
    <p>
        Mensagem: {{$dados->mensagem}}
    </p>
</body>
</html>