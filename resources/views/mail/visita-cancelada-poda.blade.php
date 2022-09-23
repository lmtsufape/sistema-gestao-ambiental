@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A visita agendada para {{$data_marcada}} no endereço {{$poda->endereco->enderecoSimplificado()}} referente a uma solicitação de poda/supressão foi cancelada. <br>
    </p>
    @include('mail.footer')
@endcomponent
