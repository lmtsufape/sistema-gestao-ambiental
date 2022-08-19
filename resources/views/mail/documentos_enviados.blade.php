@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        O status do seu requerimento nº {{$requerimento->id}}, da empresa/serviço {{$requerimento->empresa->nome}} com {{$requerimento->empresa->eh_cnpj ? 'CNPJ' : 'CPF'}} {{$requerimento->empresa->cpf_cnpj}} foi alterado para documentos enviados. Por favor analise os documentos e dê seguimento ao processo.
    </p>
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Laboratório Multidisciplinar de Tecnologias Sociais<br>
    Universidade Federal do Agreste de Pernambuco
@endcomponent
