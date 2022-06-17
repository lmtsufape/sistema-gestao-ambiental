@guest
<x-guest-layout>

    <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;" id="div-voltar">
                        <script>
                            if(window.history.length > 1){
                                $(document).ready(function() {
                                    let bottao = `<a title="Voltar" href="javascript:window.history.back();" ><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar"></a>`;
                                    $('#div-voltar').append(bottao);
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>
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

</x-guest-layout>
@else
<x-app-layout>
    @section('content')
        <div class="container" style="margin-top: 50px; margin-bottom: 50px;">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="form-row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4" style="text-align: right; padding-top: 15px;" id="div-voltar">
                            <script>
                                if(window.history.length > 1){
                                    $(document).ready(function() {
                                        let bottao = `<a title="Voltar" href="javascript:window.history.back();" ><img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar"></a>`;
                                        $('#div-voltar').append(bottao);
                                    });
                                }
                            </script>
                        </div>
                    </div>
                </div>
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
    @endsection
</x-app-layout>
@endguest
