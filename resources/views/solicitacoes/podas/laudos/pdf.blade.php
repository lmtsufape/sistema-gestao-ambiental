<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Laudo Técnico Ambiental</title>
  <style>
    body{font-family:DejaVu Sans,Arial,sans-serif;font-size:12px;color:#111;}
    h1,h2{margin:0 0 10px;}
    .section{border:1px solid #ddd;padding:12px;margin-bottom:16px;border-radius:6px;}
    .label{font-weight:bold;display:block;margin-bottom:4px;}
    .img{width:100%;height:auto;margin-bottom:8px;border:1px solid #ccc;}
    .muted{color:#666;}
    .mb-8{margin-bottom:8px;}
  </style>
</head>
<body>

  {{-- ======================= LAUDO ======================= --}}
  <h1>Laudo Técnico Ambiental</h1>
  <div class="muted mb-8">
    Protocolo: {{ $laudo->solicitacaoPoda->protocolo ?? '-' }} |
    ID: {{ $laudo->id }} |
    Data: {{ optional($laudo->created_at)->format('d/m/Y') }}
  </div>

  <div class="section">
    <div class="label">Observações</div>
    {{ $laudo->condicoes }}

    <div class="label">Localização</div>
    {{ $laudo->localizacao }}

    <div class="label">Atividade</div>
    {{ $rotulo }}

    @if ($laudo->solicitacaoPoda->area == 2 && $laudo->licenca)
      <div class="label">Licença Ambiental</div>
      Licença anexada ao processo.
    @endif
  </div>

  @if(isset($imagensLaudo) && $imagensLaudo->count())
    <h2>Imagens do Laudo</h2>
    @foreach($imagensLaudo as $img)
      <img class="img" src="{{ $img['src'] }}" alt="Foto do laudo">
      @if(!empty($img['comentario'])) <p class="muted">{{ $img['comentario'] }}</p> @endif
    @endforeach
  @endif

  {{-- ==================== SOLICITAÇÃO ==================== --}}
  <h2>Dados da Solicitação</h2>
  <div class="section">
    <div class="label">Nome</div>
    {{ $solicitacao->requerente->user->name }}

    <div class="label">E-mail</div>
    {{ $solicitacao->requerente->user->email }}

    <div class="label">CPF</div>
    {{ $solicitacao->requerente->cpf }}

    <div class="label">Endereço</div>
    Rua {{ $solicitacao->endereco->rua }},
    nº {{ $solicitacao->endereco->numero }},
    Bairro {{ $solicitacao->endereco->bairro }},
    CEP {{ $solicitacao->endereco->cep }},
    Garanhuns – PE

    @if($solicitacao->telefone)
      <div class="label">Contato</div>
      {{ $solicitacao->telefone->numero }}
    @endif

    <div class="label">Data da solicitação</div>
    {{ \Carbon\Carbon::parse($solicitacao->created_at)->format('d/m/Y') }}

    @if($solicitacao->nome_solicitante)
      <div class="label">Nome do solicitante</div>
      {{ $solicitacao->nome_solicitante }}
    @endif

    @if($solicitacao->comentario)
      <div class="label">Motivo da poda</div>
      {{ $solicitacao->comentario }}
    @endif

    @if($solicitacao->motivo_solicitacao)
      <div class="label">Motivo do corte</div>
      {{ $solicitacao->motivo_solicitacao }}
    @endif
  </div>

  @if(isset($imagensSolicitacao) && $imagensSolicitacao->count())
    <h2>Imagens da Solicitação</h2>
    @foreach($imagensSolicitacao as $img)
      <img class="img" src="{{ $img['src'] }}" alt="Foto da solicitação">
      @if(!empty($img['comentario'])) <p class="muted">{{ $img['comentario'] }}</p> @endif
    @endforeach
  @endif

</body>
</html>
