@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A solicitação de poda/supressão foi recebida com sucesso. Segue o protocolo gerado. {{$solicitacao->protocolo}}
    </p>
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Laboratório Multidisciplinar de Tecnologias Sociais<br>
    Universidade Federal do Agreste de Pernambuco
@endcomponent
