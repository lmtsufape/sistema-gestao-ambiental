<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Visualizar licença
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Licença com nº de referência {{$licenca->protocolo}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Programação > Visualizar licença</h6>
                            </div>
                        </div>
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