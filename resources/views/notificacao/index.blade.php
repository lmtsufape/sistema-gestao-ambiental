<x-app-layout>
    @section('content')
    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Notificações à empresa {{$empresa->nome}} registradas no sistema</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" @can('isSecretarioOrAnalista', \App\Models\User::class) href="{{route('empresas.listar')}}" @else href="{{route('empresas.index')}}" @endcan>Empresas</a> > @can('isSecretarioOrAnalista', \App\Models\User::class)<a class="text-muted" href="{{route('empresas.show', $empresa)}}">Dados da empresa {{$empresa->nome}}</a> >@endcan Notificações</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        {{-- <a title="Voltar" href="{{route('visitas.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                        @can('create', App\Models\Notificacao::class)
                            <a title="Criar notificação" href="{{route('empresas.notificacoes.create', ['empresa' => $empresa])}}">
                                <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de criar notificação">
                            </a>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    @if(session('success'))
                        <div class="col-md-12" style="margin-top: 5px;">
                            <div class="alert alert-success" role="alert">
                                <p>{{session('success')}}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @forelse ($notificacoes as $i => $notificacao)
                <div class="col-md-10 mt-2">
                    <a href="{{route('notificacoes.show', ['notificacao' => $notificacao])}}">
                        <div class="card notificacao-card
                        @can('isRequerente', \App\Models\User::class)
                            @if(!$notificacao->visto)
                                nao-visto
                            @endif
                        @endcan">
                            <div class="card-body">
                                <div class="justify-content-between">
                                    <div class="row align-items-center">
                                        @if ($notificacao->autor != null)
                                            <div class="col-md-1">
                                                <img class="photo-perfil" src="{{$notificacao->autor->profile_photo_path != null ? asset('storage/'.$notificacao->autor->profile_photo_path) : asset('img/user_img_perfil.png')}}" alt="Imagem de perfil">
                                            </div>
                                        @endif
                                        <div class="col-md-11">
                                            <span class="texto-card-highlight">
                                                @if ($notificacao->autor != null)
                                                    {{$notificacao->autor->name}}
                                                @endif
                                            </span>
                                            <br>{!! mb_strimwidth(strip_tags($notificacao->texto), 0, 50, "...") !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center justify-content-end texto-card-highlight" style="font-weight: normal; padding-right: 10px; text-align: right;">
                                    @can('isSecretarioOrAnalista', \App\Models\User::class)
                                        @if($notificacao->visto)
                                        <span style="padding-right: 8px;">
                                            <img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Analisar" title="Analisar">
                                        </span>
                                        @endif
                                    @endcan
                                    {{date('d/m/Y H:i', strtotime($notificacao->created_at))}}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="shadow card col-md-10 mt-3">
                    <div class="card-body">
                        <div class="text-center">
                            Nenhuma notificação registrada.
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                {{$notificacoes->links()}}
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
