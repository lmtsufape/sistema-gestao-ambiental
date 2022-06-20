@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A visita agendada para o endereço {{$poda->endereco->enderecoSimplificado()}} referente a uma solicitação de poda/supressão foi alterada para uma nova data. <br>
        A visita ficou marcada para {{$data_marcada}}.
    </p>
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Laboratório Multidisciplinar de Tecnologias Sociais<br>
    Universidade Federal do Agreste de Pernambuco
@endcomponent
