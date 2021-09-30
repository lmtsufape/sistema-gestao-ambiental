<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Empresas') }}
        </h2>
    </x-slot>
    
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Suas empresas cadastradas</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Empresas</h6>
                            </div>
                            <div class="col-md-4" style="text-align: right">
                                <a class="btn btn-primary" href="{{route('empresas.create')}}">Criar empresa</a>
                            </div>
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
                                        <th scope="col">Nome</th>
                                        <th scope="col">CPF/CNPJ</th>
                                        <th scope="col">Tipologia</th>
                                        <th scope="col">Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($empresas as $i => $empresa)
                                        <tr>
                                            <th scope="row">{{$i+1}}</th>
                                            <td>{{$empresa->nome}}</td>
                                            <td>{{$empresa->cpf_cnpj}}</td>
                                            <td>{{$empresa->cnaes()->first()->setor->nome}}</td>
                                            <td>
                                                <a href="{{route('empresas.edit', ['empresa' => $empresa])}}" class="btn btn-info">
                                                    Editar
                                                </a>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalStaticDeletarUser_{{$empresa->id}}">
                                                    Deletar
                                                </button>
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