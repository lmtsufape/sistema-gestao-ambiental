@php
    use App\Models\RequerimentoDocumento;
@endphp

@component('mail::message')

    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        O status das exigências de documentação do seu requerimento nº {{$requerimento->id}}, da empresa/serviço {{$requerimento->empresa->nome}} com {{$requerimento->empresa->eh_cnpj ? 'CNPJ' : 'CPF'}} {{$requerimento->empresa->cpf_cnpj}} foi alterado.
    </p>
    <p style="color: black; font-family: 'Times New Roman', Times, serif; font-weight: bold;">
        Segue a relação da análise abaixo:
    </p>
    <ul style="color: black; font-family: 'Times New Roman', Times, serif;">
        @foreach ($documentos as $documento)
            @foreach ($requerimento_documentos as $requerimento_documento)
                @if ($requerimento_documento->documento_id == $documento->id)
                    <li>
                        <p style="color: black; font-family: 'Times New Roman', Times, serif;">
                            {{$documento->nome}} - 
                            @if($requerimento_documento->status == RequerimentoDocumento::STATUS_ENUM['aceito'])
                                <span style="color: green;">Aceito</span>
                            @else
                                <span style="color: red;">Recusado</span>
                            @endif
                        </p>
                        <p style="color: black; font-family: 'Times New Roman', Times, serif;"> Comentário: {{$requerimento_documento->comentario_anexo}}</p>
                    </li>
                @endif
            @endforeach
        @endforeach
        @foreach ($requerimento_documentos as $requerimento_documento)
                @if($requerimento_documento->nome_outro_documento != null)
                    <li>
                        <p style="color: black; font-family: 'Times New Roman', Times, serif;">
                            {{$requerimento_documento->nome_outro_documento}} - 
                            @if($requerimento_documento->status == RequerimentoDocumento::STATUS_ENUM['aceito'])
                                <span style="color: green;">Aceito</span>
                            @else
                                <span style="color: red;">Recusado</span>
                            @endif
                        </p>
                        <p style="color: black; font-family: 'Times New Roman', Times, serif;"> Comentário: {{$requerimento_documento->comentario_outro_documento}}</p>
                    </li>
                    @break
                @endif
        @endforeach
    </ul>
    @include('mail.footer')
@endcomponent
