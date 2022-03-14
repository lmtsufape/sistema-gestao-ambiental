<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-between">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Suas solicitações de mudas</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Cadastrar solicitação de muda" href="{{route('mudas.create')}}">
                            <img class="icon-licenciamento add-card-btn" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de adicionar solicitação de muda">
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
                        <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Quantidade de mudas</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitacoes as $i => $solicitacao)
                                        <tr>
                                            <th scope="row">{{$i+1}}</th>
                                            <td>{{$solicitacao->created_at}}</td>
                                            <td>{{ucfirst(array_search($solicitacao->status, App\Models\SolicitacaoMuda::STATUS_ENUM))}}</td>
                                            <td>{{$solicitacao->qtd_mudas}}</td>
                                            <td>
                                                <a title="Visualizar" href="{{route('mudas.mostrar', $solicitacao)}}"><img class="icon-licenciamento" src="{{asset('img/Visualizar.svg')}}" alt="Icone de visualizar"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                        @if($solicitacoes->first() == null)
                            <div class="col-md-12 text-center" style="font-size: 18px;">
                                Nenhuma solicitação feita
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #f8f9fa; border-radius: 00.5rem; margin-top: 2.6rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <ul class="list-group list-unstyled">
                        <li>
                            <div title="Visualizar solicitação" class="d-flex align-items-center my-1 pt-0 pb-1" style="border-bottom:solid 2px #e0e0e0;">
                                <img class="aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Visualizar solicitação">
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
</x-app-layout>
