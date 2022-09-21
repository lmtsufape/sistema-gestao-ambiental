@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A visita agendada para a empresa {{$requerimento->empresa->nome}} do requerimento de {{$requerimento->tipoString()}} foi alterada para uma nova data. <br>
        A visita será realizada até {{$data_marcada}}.
    </p>
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Laboratório Multidisciplinar de Tecnologias Sociais<br>
    Universidade Federal do Agreste de Pernambuco
@endcomponent
