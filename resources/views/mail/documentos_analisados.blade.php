@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        O status do seu requerimento nº {{$requerimento->id}}, da empresa/serviço {{$requerimento->empresa->nome}} com {{$requerimento->empresa->eh_cnpj ? 'CNPJ' : 'CPF'}} {{$requerimento->empresa->cpf_cnpj}} foi alterado para
        @switch($requerimento->status)
            @case(\App\Models\Requerimento::STATUS_ENUM['documentos_requeridos'])
                documentos requeridos.
                @break
            @case(\App\Models\Requerimento::STATUS_ENUM['documentos_aceitos'])
                documentos aceitos.
                @break
        @endswitch Segue a relação da analise abaixo.@if($requerimento->status == \App\Models\requerimento::STATUS_ENUM['documentos_requeridos']) Por favor reenvie os documentos de acordo com as especificações.@endif
    </p>
    <ul style="color: black; font-family: 'Times New Roman', Times, serif;">
        @foreach ($documentos as $documento)
            <li>
                @switch($documento->pivot->status)
                    @case(\App\Models\Checklist::STATUS_ENUM['aceito'])
                        @if ($documento->pivot->comentario)
                            {{$documento->nome.' (aceito, comentário: '.$documento->pivot->comentario.')'}}
                        @else
                            {{$documento->nome.' (aceito)'}}
                        @endif
                        @break
                    @case(\App\Models\Checklist::STATUS_ENUM['recusado'])
                        {{$documento->nome . ' (recusado, motivo: ' . $documento->pivot->comentario . ')'}}
                        @break
                @endswitch
            </li>
        @endforeach
    </ul>
    @include('mail.footer')
@endcomponent
