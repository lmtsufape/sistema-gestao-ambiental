<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-between">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Suas solicitações de mudas</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Cadastrar solicitação de muda" href="{{route('mudas.create')}}">
                            <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar solicitação de muda">
                        </a>
                    </div>
                </div>
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <div div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitacoes as $i => $solicitacao)
                                        <tr>
                                            <th scope="row">{{ ($solicitacoes->currentpage()-1) * $solicitacoes->perpage() + $loop->index + 1 }}</th>
                                            <td>{{$solicitacao->created_at->format('d/m/Y H:i')}}</td>
                                            <td>{{ucfirst($solicitacao->statusSolicitacao())}}</td>
                                            <td>
                                                <a title="Visualizar" href="{{route('mudas.mostrar', $solicitacao)}}"><img width="20px;" class="icon-licenciamento" src="{{asset('img/Visualizar.svg')}}" alt="Icone de visualizar"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                        </div>
                        @if($solicitacoes->first() == null)
                            <div class="col-md-12 text-center" style="font-size: 18px;">
                                Nenhuma solicitação feita
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-row justify-content-center">
                    <div class="col-md-10">
                        {{$solicitacoes->links()}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 2.6rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    <ul class="list-group list-unstyled">
                        <li>
                            <div title="Cadastrar solicitação de muda" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" style="border-radius: 50%;" width="20" src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de Cadastrar solicitação de muda">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Cadastrar solicitação de muda
                                </div>
                            </div>
                        </li>
                        <li>
                            <div title="Visualizar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1">
                                <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visualizar solicitação">
                                <div style="font-size: 15px;" class="aling-middle mx-3">
                                    Visualizar solicitação
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
