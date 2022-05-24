<x-app-layout>
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Licença com nº de referência {{$licenca->protocolo}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Programação > Visualizar licença</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Voltar" @can('isRequerente', \App\Models\User::class)  href="javascript:window.history.back();" @else href="{{route('visitas.index')}}" @endcan >
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-12">
                                <iframe src="{{asset('storage/'.$licenca->caminho)}}" frameborder="0" width="100%" height="500px"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: left">
                                <label for="">Válida até:</label>
                                <input type="date" disabled value="{{$licenca->validade}}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>