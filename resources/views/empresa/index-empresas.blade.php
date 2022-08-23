<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            @livewire('empresas-index')
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 2.6rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    <ul class="list-group list-unstyled">
                        <li>
                            <div title="Visualizar empresa" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visualizar empresa">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Visualizar empresa
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
