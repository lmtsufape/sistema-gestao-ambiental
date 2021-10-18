<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notificações') }}
        </h2>
    </x-slot>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Notificações à empresa {{$empresa->nome}} cadastradas no sistema</h5>
                            </div>
                            @can('create', App\Models\Notificacao::class)
                                <div class="col-md-4" style="text-align: right">
                                    <a class="btn btn-primary" href="{{route('empresas.notificacoes.create', ['empresa' => $empresa])}}">Criar notificação</a>
                                </div>
                            @endif
                        </div>
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
                                                <a href="{{route('notificacoes.show', ['notificacao' => $notificacao])}}">Visualizar</a>
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
