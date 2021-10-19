<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notificação') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Notificação da empresa {{$notificacao->empresa->nome}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Programação > Visita > Notificações</h6>
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
                                        <img class="img-fluid" src="{{Storage::url($foto->caminho)}}" alt="foto">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






</x-app-layout>
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
