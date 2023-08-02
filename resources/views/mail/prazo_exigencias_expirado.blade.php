@component('mail::message')
    <p>O prazo de exigências para o cumprimento das exigências para emissão da licença da empresa {{ $requerimento_documento->empresa->nome }} expirou.</p>
    <br>
    <p>Data de expiração: {{ $requerimento_documento->prazo_exigencias->format('d/m/Y') }}</p>
    <br>
    <p>Por favor, entre no sistema e verifique o requerimento.</p>
    @include('mail.footer')
@endcomponent