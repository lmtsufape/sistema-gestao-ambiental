@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A empresa/serviço {{ $empresa }} recebeu uma notificação @if ($imagens), as imagens seguem em anexo @endif.
    </p>
    <div>{!! $texto !!}</div>
    @if ($comentarios)
        <div>Comentário das imagens</div>
        @foreach ($comentarios as $comentario)
            <div>{{$comentario}}</div>
        @endforeach
    @endif
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Laboratório Multidisciplinar de Tecnologias Sociais<br>
    Universidade Federal do Agreste de Pernambuco
@endcomponent
