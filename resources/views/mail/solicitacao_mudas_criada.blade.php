@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A solicitação de mudas foi recebida com sucesso. Segue o protocolo gerado. {{$solicitacao->protocolo}}
    </p>
    @include('mail.footer')
@endcomponent
