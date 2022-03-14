<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Notificações à empresa {{$empresa->nome}}</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Voltar" href="{{route('empresas.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a>
                        @can('create', App\Models\Notificacao::class)
                            <a title="Criar notificação" href="{{route('empresas.notificacoes.create', ['empresa' => $empresa])}}">
                                <img class="icon-licenciamento add-card-btn" src="{{asset('img/Grupo 1666.svg')}}" alt="Icone de criar notificação">
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-10">
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
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empresa->notificacoes as $i => $notificacao)
                                        <tr>
                                            <th>{{$i+1}}</th>
                                            <td>{{date('d/m/Y', strtotime($notificacao->created_at))}}</td>
                                            <td>
                                                <a title="Visualizar notificação" href="{{route('notificacoes.show', ['notificacao' => $notificacao])}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}" alt="Icone de visualizar notificação"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
