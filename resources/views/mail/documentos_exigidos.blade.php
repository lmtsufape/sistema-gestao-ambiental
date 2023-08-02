@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        Prezado(a) {{$requerimento->empresa->nome}} com {{$requerimento->empresa->eh_cnpj ? 'CNPJ' : 'CPF'}} {{$requerimento->empresa->cpf_cnpj}} para concluir o processo de requerimento, é necessário o envio dos seguintes documentos:
    </p>
    <ul style="color: black; font-family: 'Times New Roman', Times, serif;">
        @foreach ($documentos as $documento)
            @foreach ($requerimento_documentos as $pivor)
                @if ($pivor->documento_id == $documento->id)
                    <li>{{$documento->nome}}</li>
                @endif
            @endforeach
        @endforeach
        @foreach ($requerimento_documentos as $pivor)
            @if($pivor->nome_outro_documento != null)
                <li>{{$pivor->nome_outro_documento}}</li>
                @break
            @endif
        @endforeach
    </ul>
    @include('mail.footer')
@endcomponent