<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Usuários') }}
        </h2>
    </x-slot>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                      <div class="form-row">
                        <div class="col-md-8">
                            <h5 class="card-title">Usuários cadastrados no sistema</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Usuários</h6>
                        </div>
                        <div class="col-md-4" style="text-align: right">
                            <a class="btn btn-primary" href="{{route('usuarios.create')}}">Criar usuário</a>
                        </div>
                      </div>
                      <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">e-mail</th>
                                    <th scope="col">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td></td>
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