<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Notificação à empresa {{$notificacao->empresa->nome}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Programação > Visitas > Notificações > Visualizar notificação</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Voltar" href="{{route('empresas.notificacoes.index', ['empresa' => $notificacao->empresa])}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a>
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
                                <div class="card-body">
                                    <div class="alert alert-warning" role="alert">
                                        <div id="notificacao" style="margin-top: 10px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                @foreach ($notificacao->fotos as $foto)
                                    <img class="img-fluid" src="{{asset('storage/' . $foto->caminho)}}" alt="foto">
                                    @if ($foto->comentario != null)
                                        <div class="card-body">
                                            <p class="card-text">{{$foto->comentario}}</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
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
