@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        Foi agendada uma visita para o endereço {{$poda->endereco->enderecoSimplificado()}} referente a uma solicitação de poda/supressão. <br>
        A visita será realizada até {{$data_marcada}}.
    </p>
    @include('mail.footer')
@endcomponent
