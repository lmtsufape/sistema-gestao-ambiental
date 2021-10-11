<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        Foi criada uma notificação para a empresa {{ $empresa }} @if ($imagens), as imagens seguem em anexo.@endif
    </p>
    <div>{!! $texto !!}</div>
    @if ($comentarios)
        <div>Comentário das imagens</div>
        @foreach ($comentarios as $comentario)
            <div>{{$comentario}}</div>
        @endforeach
    @endif
    <p style="'Times New Roman', Times, serif; font-size: 12px;">
        Atenciosamente, <br>
        {{ config('app.name') }} <br>
        Laboratório Multidisciplinar de Tecnologias Sociais<br>
        Universidade Federal do Agreste de Pernambuco
    </p>
</body>
</html>
