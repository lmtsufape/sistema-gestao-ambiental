@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        O status de seu requerimento nº {{$requerimento->id}}, da empresa/serviço {{$requerimento->empresa->nome}} foi alterado para documentos requeridos. Segue a lista de documentos para o andamento do processo
    </p>
    <ul style="color: black; font-family: 'Times New Roman', Times, serif;">
        @foreach ($documentos as $documento)
            <li>{{$documento->nome}}</li>
        @endforeach
    </ul>
    @lang('Regards'),<br>
    {{ config('app.name') }}<br>
    Laboratório Multidisciplinar de Tecnologias Sociais<br>
    Universidade Federal do Agreste de Pernambuco
@endcomponent
