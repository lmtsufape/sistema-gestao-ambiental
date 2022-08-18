<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Notificação à empresa {{$notificacao->empresa->nome}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" @can('isSecretarioOrAnalista', \App\Models\User::class) href="{{route('empresas.listar')}}" @else href="{{route('empresas.index')}}" @endcan>Empresas</a> > @can('isSecretarioOrAnalista', \App\Models\User::class)<a class="text-muted" href="{{route('empresas.show', $notificacao->empresa)}}">Dados da empresa {{$notificacao->empresa->nome}}</a> >@endcan <a class="text-muted" href="{{route('empresas.notificacoes.index', ['empresa' => $notificacao->empresa])}}"> Notificações</a> > Notificação</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        {{-- <a title="Voltar" href="{{route('empresas.notificacoes.index', ['empresa' => $notificacao->empresa])}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="col-md-12" style="margin-top: 5px;">
                                <div class="alert alert-success" role="alert">
                                    <p>{{session('success')}}</p>
                                </div>
                            </div>
                        @endif
                        <div class="form-row">
                            <div class="col-md-12" style="margin-bottom:20px">
                                <div class="card notificacao-card border-none">
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
                                                    <br>{!!$notificacao->texto!!}
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
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            @foreach ($notificacao->fotos as $foto)
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <img class="img-fluid" src="{{route('notificacoes.foto', ['notificacao' => $notificacao->id, 'foto' => $foto->id])}}" alt="foto" width="400px">
                                        @if ($foto->comentario != null)
                                            <div class="card-body">
                                                <p class="card-text">{{$foto->comentario}}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                             @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script scr="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{route('notificacoes.get')}}",
                method: 'get',
                type: 'get',
                data: {"notificacao_id": "{{$notificacao->id}}"},
                dataType:'json',
                success: function(notificacao){
                    var divNificacao = document.getElementById('notificacao');
                    divNificacao.innerHTML = notificacao.texto;
                },
            });
        });
    </script>
    @endsection
</x-app-layout>
