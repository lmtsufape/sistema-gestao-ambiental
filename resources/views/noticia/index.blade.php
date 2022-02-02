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
                                    <img src="{{asset('storage/'.$noticia->imagem_principal)}}" alt="Imagem da notícia {{$noticia->titulo}}" height="170px" width="100%" style="max-height: 170px; max-width: 100%;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                    <h5 class="card-title">{{$noticia->titulo}}</h5>
                                    <p class="card-text">{!! mb_strimwidth($noticia->texto, 0, 100, "...") !!}</p>
                                    <p class="card-text"><small class="text-muted retirar-formatacao" style="text-decoration: none;">{{$noticia->ultimaAtualizacao()}}</small></p>
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