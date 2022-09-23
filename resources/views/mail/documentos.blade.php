@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        O status do seu requerimento nº {{$requerimento->id}}, da empresa/serviço {{$requerimento->empresa->nome}} com {{$requerimento->empresa->eh_cnpj ? 'CNPJ' : 'CPF'}} {{$requerimento->empresa->cpf_cnpj}} foi alterado para documentos requeridos. Segue a lista de documentos para o andamento do processo
    </p>
    <ul style="color: black; font-family: 'Times New Roman', Times, serif;">
        @foreach ($documentos as $documento)
            <li>{{$documento->nome}}</li>
        @endforeach
    </ul>
    @include('mail.footer')
@endcomponent
