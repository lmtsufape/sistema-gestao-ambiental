<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            @livewire('usuarios-index')
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    <ul class="list-group list-unstyled">
                        <li>
                            <div title="Adicionar usuário" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar usuário">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Adicionar usuário
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Editar usuário" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/edit-svgrepo-com.svg')}}" alt="Editar usuário">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Editar usuário
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Deletar usuário" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/trash-svgrepo-com.svg')}}" alt="Deletar usuário">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Deletar usuário
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
