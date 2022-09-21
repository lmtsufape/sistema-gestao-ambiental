@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A visita agendada para o endereço {{$poda->endereco->enderecoSimplificado()}} referente a uma solicitação de poda/supressão foi alterada para uma nova data. <br>
        A visita será realizada até {{$data_marcada}}.
    </p>
    @include('mail.footer')
@endcomponent
