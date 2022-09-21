@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        Foi agendada uma visita para a empresa {{$requerimento->empresa->nome}} para dar continuidade ao requerimento de {{$requerimento->tipoString()}}. <br>
        A visita será realizada até {{$data_marcada}}.
    </p>
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Laboratório Multidisciplinar de Tecnologias Sociais<br>
    Universidade Federal do Agreste de Pernambuco
@endcomponent
