@component('mail::message')

    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        O status das exigências de documentação do seu requerimento nº {{$requerimento->id}}, da empresa/serviço {{$requerimento->empresa->nome}} com {{$requerimento->empresa->eh_cnpj ? 'CNPJ' : 'CPF'}} {{$requerimento->empresa->cpf_cnpj}} foi alterado.
    </p>
    <p style="color: black; font-family: 'Times New Roman', Times, serif; font-weight: bold;">
        Segue a relação da análise abaixo:
    </p>
    <ul style="color: black; font-family: 'Times New Roman', Times, serif;">
        @foreach ($documentos as $documento)
            @php
                $requerimento_documento = $requerimento_documentos->where('requerimento_id', $requerimento->id)->where('documento_id', $documento->id)->first();
            @endphp
            @if ($requerimento_documento)
                <li>
                    @switch($requerimento_documento->status)
                        @case(\App\Models\Checklist::STATUS_ENUM['aceito'])
                            @if ($requerimento_documento->comentario_anexo)
                                {{$documento->nome.' (aceito, comentário: '.$requerimento_documento->comentario_anexo.')'}}
                            @else
                                {{$documento->nome.' (aceito)'}}
                            @endif
                            @break
                        @case(\App\Models\Checklist::STATUS_ENUM['recusado'])
                            @if ($requerimento_documento->comentario_anexo)
                                {{$documento->nome.' (recusado, motivo:' .$requerimento_documento->comentario_anexo. ')'}}
                            @else
                                {{$documento->nome.' (recusado)'}}
                            @endif
                            @break
                    @endswitch
                </li>
            @endif
        @endforeach
        @foreach ($requerimento_documentos as $requerimento_documento)
            @if ($requerimento_documento->nome_outro_documento != null)
                <li>
                    @switch($requerimento_documento->status)
                        @case(\App\Models\Checklist::STATUS_ENUM['aceito'])
                            @if ($requerimento_documento->comentario_outro_documento)
                                {{$requerimento_documento->nome_outro_documento.' (aceito, comentário: '.$requerimento_documento->comentario_outro_documento.')'}}
                            @else
                                {{$requerimento_documento->nome_outro_documento.' (aceito)'}}
                            @endif
                            @break
                        @case(\App\Models\Checklist::STATUS_ENUM['recusado'])
                            @if ($requerimento_documento->comentario_outro_documento)
                                {{$requerimento_documento->nome_outro_documento.' (recusado, motivo:' .$requerimento_documento->comentario_outro_documento. ')'}}
                            @else
                                {{$requerimento_documento->nome_outro_documento.' (recusado)'}}
                            @endif
                            @break
                    @endswitch
                </li>
            @endif
        @endforeach
    </ul>
    @include('mail.footer')
@endcomponent
