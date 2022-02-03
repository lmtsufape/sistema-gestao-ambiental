<x-guest-layout>
    @component('layouts.nav_bar')@endcomponent
    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-3">
                    <img src="{{asset('storage/'.$noticia->imagem_principal)}}" class="card-img-top" alt="Imagem da notícia {{$noticia->titulo}}">
                    <div class="card-body">
                        <h5 class="card-title">{{$noticia->titulo}}</h5>
                        <p class="card-text">{!! $noticia->texto !!}</p>
                        <p class="card-text"><small class="text-muted">{{$noticia->autor->name}} - {{$noticia->exibirDatas() ? $noticia->dataPublicado() : $noticia->dataPublicado() . ' - ' . $noticia->ultimaAtualizacao()}}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('layouts.footer')@endcomponent
</x-guest-layout>