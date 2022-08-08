<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        @if ($visita->requerimento != null)
                            <h4 class="card-title">Cria relátorio do requerimento nº {{$visita->requerimento->id}}</h4>
                        @elseif ($visita->denuncia != null)
                            <h4 class="card-title">Cria relátorio da denúncia nº {{$visita->denuncia->id}}</h4>
                        @elseif ($visita->solicitacao_poda != null)
                            <h4 class="card-title">Cria relátorio da solicitação de poda nº {{$visita->solicitacao_poda->id}}</h4>
                        @endif
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('visitas.index', 'requerimento')}}">Programação</a> > Visitas > Criar relátorio</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        {{-- <a title="Voltar" href="{{route('visitas.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form col-md-9" style="margin-top:30px;">
                                <form id="form-relatorio-visita" method="POST" action="{{route('relatorios.store')}}">
                                    @csrf
                                    <input type="hidden" name="visita" value="{{$visita->id}}">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <textarea id="relatorio" name="texto" required>{{old('texto')}}</textarea>
                                </form>
                            </div>
                            <div class="form col-md-3">
                                <div class="col barraMenu">
                                    <p style="margin-bottom:6px;">Álbum</p>
                                </div>
                                <div id="imagens" class="form-row" style="width:100%; height:400px; overflow:auto;">
                                    @foreach ($visita->fotos as $foto)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card" style="width: 100%;">
                                                    <img src="{{route('visitas.foto', ['visita' => $visita->id, 'foto' => $foto->id])}}" class="card-img-top" alt="...">
                                                    @if ($foto->comentario != null)
                                                        <div class="card-body">
                                                            <p class="card-text">{{$foto->comentario}}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div><br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6 form-group"></div>
                            <div class="col-md-6 form-group">
                                <button class="btn btn-success btn-color-dafault  submeterFormBotao" style="width: 100%;" form="form-relatorio-visita">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('relatorio');
    </script>
    @endsection
</x-app-layout>
