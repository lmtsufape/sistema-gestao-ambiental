<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Notícias escritas</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        {{-- @can('create', App\Models\Noticia::class) --}}
                            <a title="Criar notificação" href="{{route('noticias.create')}}">
                                <img class="icon-licenciamento add-card-btn" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de criar notícia">
                            </a>
                        {{-- @endif --}}
                    </div>
                </div>
                @foreach ($noticias as $noticia)
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
                                                <p class="card-text"><small class="text-muted retirar-formatacao" style="text-decoration: none;">{{$noticia->ultimaAtualizacao()}}</small></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{route('noticias.edit', ['noticia' => $noticia])}}" class="card-link" style="text-decoration: none;"><img class="icon-licenciamento" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Icone editar notícia"></a>
                                                <a href="#" class="card-link" style="text-decoration: none;"><img class="icon-licenciamento" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Icone deletar notícia"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</x-app-layout>