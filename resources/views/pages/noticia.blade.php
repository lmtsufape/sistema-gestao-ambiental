<div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
    <div class="form-row justify-content-center">
        <div class="col-md-10">
            <div class="form-row">
                <div class="col-md-8">
                    <div style="color: var(--primaria); font-size: 35px; font-weight: bolder;">
                        @can('create', App\Models\Noticia::class)
                            Notícias escritas
                        @else
                            Notícias
                        @endcan
                    </div>
                </div>
                <div class="col-md-4" style="text-align: right">
                    @can('create', App\Models\Noticia::class)
                        <a title="Criar notícia" href="{{route('noticias.create')}}">
                            <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de criar notícia">
                        </a>
                    @endcan
                </div>
            </div>
            <div class="form-row">
                @if(session('success'))
                    <div class="col-md-12" style="margin-top: 5px;">
                        <div class="alert alert-success" role="alert">
                            <p>{{session('success')}}</p>
                        </div>
                    </div>
                @endif
            </div>
            @forelse ($noticias as $noticia)
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card mb-3" style="max-width: 100%;">
                            <div class="row no-gutters">
                                <div class="col-md-4" style="text-align: right;">
                                    <img src="{{asset('storage/'.$noticia->imagem_principal)}}" alt="Imagem da notícia {{$noticia->titulo}}" height="192px" width="100%" style="min-height: 192px; min-width: 100%; max-height: 192px; max-width: 100%;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{$noticia->link}}" style="text-decoration-color: black;"><h5 class="card-title">{{$noticia->titulo}}</h5></a>
                                                <p class="card-text">{!! mb_strimwidth($noticia->texto, 0, 100, "...") !!}</p>
                                                <p class="card-text"><small class="text-muted retirar-formatacao" style="text-decoration: none;">{{$noticia->exibirDatas() ? $noticia->dataPublicado() : $noticia->dataPublicado() . ' - ' . $noticia->ultimaAtualizacao()}}</small></p>
                                            </div>
                                        </div>
                                        @can('isSecretario', app\Models\User::class)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="{{route('noticias.edit', ['noticia' => $noticia])}}" class="card-link" style="text-decoration: none;"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone editar notícia"></a>
                                                    <a style="cursor: pointer;"  data-toggle="modal" data-target="#modal-deletar-noticia-{{$noticia->id}}" class="card-link" style="text-decoration: none;"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone deletar notícia"></a>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card" style="width: 100%;">
                            <div class="card-body">
                                <div class="col-md-12 text-center" style="font-size: 18px;">
                                    @can('isSecretario', app\Models\User::class)
                                        {{__('Nenhuma notícia criada')}}
                                    @else
                                        {{__('Nenhuma notícia publicada')}}
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <div class="form-row justify-content-center">
        <div class="col-md-10">
            {{$noticias->links()}}
        </div>
    </div>
</div>
