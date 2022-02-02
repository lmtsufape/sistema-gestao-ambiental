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
            </div>
            @foreach ($noticias as $noticia)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row no-gutters">
                              <div class="col-md-4">
                                <img src="..." alt="...">
                              </div>
                              <div class="col-md-8">
                                <div class="card-body">
                                  <h5 class="card-title">Card title</h5>
                                  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>