@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A visita agendada para {{$data_marcada}}, para a empresa {{$requerimento->empresa->nome}} do requerimento de {{$requerimento->tipoString()}} foi cancelada. <br>
    </p>
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Laboratório Multidisciplinar de Tecnologias Sociais<br>
    Universidade Federal do Agreste de Pernambuco
@endcomponent
