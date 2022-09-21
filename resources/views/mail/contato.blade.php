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
@include('mail.footer')
@endcomponent
