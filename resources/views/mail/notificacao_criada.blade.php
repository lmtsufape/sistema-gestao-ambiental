@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A empresa/serviço {{ $empresa }} recebeu uma notificação.@if ($imagens) Seguem as imagens anexadas.@endif
    </p>
    <div>{!! $texto !!}</div>
    @if ($comentarios)
        <div>Comentário das imagens</div>
        @foreach ($comentarios as $comentario)
            <div>{{$comentario}}</div>
        @endforeach
    @endif
    @include('mail.footer')
@endcomponent
