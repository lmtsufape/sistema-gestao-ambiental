@component('mail::message')
<p  style="color: black; font-family: 'Times New Roman', Times, serif;">
    Nome completo: {{$dados->nome_completo}}
</p>
<p  style="color: black; font-family: 'Times New Roman', Times, serif;">
    E-mail para contato: {{$dados->email}}
</p>
<p  style="color: black; font-family: 'Times New Roman', Times, serif;">
    Mensagem: {{$dados->mensagem}}
</p>
@lang('Regards'),<br>
{{ config('app.name') }}<br>
Laboratório Multidisciplinar de Tecnologias Sociais<br>
Universidade Federal do Agreste de Pernambuco
@endcomponent
