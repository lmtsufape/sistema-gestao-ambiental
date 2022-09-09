@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A solicitação de poda/supressão com protocolo {{$solicitacao->protocolo}} foi encaminhada a um analista. Aguarde o deferimento da sua solicitação.
    </p>
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Secretaria Municipal de Desenvolvimento Rural e Meio Ambiente<br>
    Prefeitura Municipal de Garanhuns - PE
@endcomponent
