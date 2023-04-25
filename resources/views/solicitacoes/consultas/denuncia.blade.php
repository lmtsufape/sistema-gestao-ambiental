@guest
<x-guest-layout>


    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Denúncia</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" href="{{route('denuncias.create')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="empresa">Empresa denunciada:</label>
                                @if ($solicitacao->empresa_id != null)
                                    <input id="empresa" class="form-control @error('empresa') is-invalid @enderror" type="text" name="empresa" value="{{$solicitacao->empresa->nome}}" disabled autocomplete="empresa">
                                @else
                                    <input id="empresa" class="form-control @error('empresa') is-invalid @enderror" type="text" name="empresa" value="{{$solicitacao->empresa_nao_cadastrada}}" disabled autocomplete="empresa">
                                @endif
                            </div>

                            @if ($solicitacao->empresa_id == null)
                                <div class="col-md-12">
                                    <label for="endereco">Endereço:</label>
                                    <input id="endereco" class="form-control @error('endereco') is-invalid @enderror" type="text" name="endereco" value="{{$solicitacao->endereco}}" disabled autocomplete="endereco">
                                </div>
                            @endif
                        </div>
                        @if ($solicitacao->denunciante != null)
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label for="denunciante">Denunciante:</label>
                                    <input id="denunciante" class="form-control @error('denunciante') is-invalid @enderror" type="text" name="denunciante" value="{{$solicitacao->denunciante}}" disabled autocomplete="denunciante">
                                </div>
                            </div>
                        @endif
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="relato">Relato:</label>
                                <div class="alert alert-warning" role="alert">
                                    <div id="relato">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($solicitacao->fotos->first() != null)
                            <br><div class="row">
                                <div class="col-12">Imagens anexadas:</div>
                            </div>
                            <div class="row">
                                @foreach ($solicitacao->fotos as $foto)
                                    <div class="col-md-6">
                                        <div class="card" style="width: 100%;">
                                            <img src="{{route('denuncias.imagem', $foto->id)}}" class="card-img-top" alt="...">
                                            @if ($foto->comentario != null)
                                                <div class="card-body">
                                                    <p class="card-text">{{$foto->comentario}}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if ($solicitacao->videos->first() != null)
                            <br><div class="row">
                                <div class="col-12">Vídeos anexados junto a denúncia:</div>
                            </div>
                            <div class="row">
                                @foreach ($solicitacao->videos as $video)
                                    <div class="col-md-6">
                                        <video width="320" height="240" controls>
                                            <source src="{{asset('storage/' . $video->caminho)}}" >
                                            Seu navegador não suporta o tipo de vídeo.
                                        </video>
                                        <div class="card" style="width: 100%;">
                                            @if ($video->comentario != null)
                                                <div class="card-body">
                                                    <p class="card-text">{{$video->comentario}}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom:20px">
                        <div class="card shadow" style="border-radius:12px; border-width:0px;">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12" style="margin-bottom: 0.5rem">
                                        <h5 class="card-title mb-0" style="color:#08a02e; font-weight:bold">Status da denúncia</h5>
                                    </div>
                                    <div class="col-md-12">
                                        @switch($solicitacao->aprovacao)
                                            @case(\App\Models\Denuncia::APROVACAO_ENUM['registrada'])
                                                <h5>Denúncia em análise.</h5>
                                                @break
                                            @case(\App\Models\Denuncia::APROVACAO_ENUM['aprovada'])
                                                <h5>A denúncia foi recebida e ações serão tomadas.</h5>
                                                @break
                                            @case(\App\Models\Denuncia::APROVACAO_ENUM['arquivada'])
                                                <h5>A denúncia foi arquivada.</h5>
                                                @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push ('scripts')
        <script scr="{{asset('ckeditor/ckeditor.js')}}"></script>
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "{{route('denuncias.get')}}",
                    method: 'get',
                    type: 'get',
                    data: {"denuncia_id": "{{$solicitacao->id}}"},
                    dataType:'json',
                    success: function(denuncia){
                        var divDenuncia = document.getElementById('relato');
                        divDenuncia.innerHTML = denuncia.texto;
                    },
                });
            });
        </script>
    @endpush
</x-guest-layout>
@else
<x-app-layout>
    @section('content')

    <div class="container" style="padding-top: 3rem; padding-bottom: 6rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Denúncia</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" href="{{route('denuncias.create')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            @if(session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{session('success')}}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="empresa">Empresa denunciada:</label>
                                @if ($solicitacao->empresa_id != null)
                                    <input id="empresa" class="form-control @error('empresa') is-invalid @enderror" type="text" name="empresa" value="{{$solicitacao->empresa->nome}}" disabled autocomplete="empresa">
                                @else
                                    <input id="empresa" class="form-control @error('empresa') is-invalid @enderror" type="text" name="empresa" value="{{$solicitacao->empresa_nao_cadastrada}}" disabled autocomplete="empresa">
                                @endif
                            </div>

                            @if ($solicitacao->empresa_id == null)
                                <div class="col-md-12">
                                    <label for="endereco">Endereço:</label>
                                    <input id="endereco" class="form-control @error('endereco') is-invalid @enderror" type="text" name="endereco" value="{{$solicitacao->endereco}}" disabled autocomplete="endereco">
                                </div>
                            @endif
                        </div>
                        @if ($solicitacao->denunciante != null)
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label for="denunciante">Denunciante:</label>
                                    <input id="denunciante" class="form-control @error('denunciante') is-invalid @enderror" type="text" name="denunciante" value="{{$solicitacao->denunciante}}" disabled autocomplete="denunciante">
                                </div>
                            </div>
                        @endif
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="relato">Relato:</label>
                                <div class="alert alert-warning" role="alert">
                                    <div id="relato">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($solicitacao->fotos->first() != null)
                            <br><div class="row">
                                <div class="col-12">Imagens anexadas:</div>
                            </div>
                            <div class="row">
                                @foreach ($solicitacao->fotos as $foto)
                                    <div class="col-md-6">
                                        <div class="card" style="width: 100%;">
                                            <img src="{{route('denuncias.imagem', $foto->id)}}" class="card-img-top" alt="...">
                                            @if ($foto->comentario != null)
                                                <div class="card-body">
                                                    <p class="card-text">{{$foto->comentario}}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if ($solicitacao->videos->first() != null)
                            <br><div class="row">
                                <div class="col-12">Vídeos anexados junto a denúncia:</div>
                            </div>
                            <div class="row">
                                @foreach ($solicitacao->videos as $video)
                                    <div class="col-md-6">
                                        <video width="320" height="240" controls>
                                            <source src="{{asset('storage/' . $video->caminho)}}" >
                                            Seu navegador não suporta o tipo de vídeo.
                                        </video>
                                        <div class="card" style="width: 100%;">
                                            @if ($video->comentario != null)
                                                <div class="card-body">
                                                    <p class="card-text">{{$video->comentario}}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom:20px">
                        <div class="card shadow" style="border-radius:12px; border-width:0px;">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12" style="margin-bottom: 0.5rem">
                                        <h5 class="card-title mb-0" style="color:#08a02e; font-weight:bold">Status da denúncia</h5>
                                    </div>
                                    <div class="col-md-12">
                                        @switch($solicitacao->aprovacao)
                                            @case(\App\Models\Denuncia::APROVACAO_ENUM['registrada'])
                                                <h5>Denúncia em análise.</h5>
                                                @break
                                            @case(\App\Models\Denuncia::APROVACAO_ENUM['aprovada'])
                                                <h5>A denúncia foi recebida e ações serão tomadas.</h5>
                                                @break
                                            @case(\App\Models\Denuncia::APROVACAO_ENUM['arquivada'])
                                                <h5>A denúncia foi arquivada.</h5>
                                                @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push ('scripts')
        <script scr="{{asset('ckeditor/ckeditor.js')}}"></script>
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "{{route('denuncias.get')}}",
                    method: 'get',
                    type: 'get',
                    data: {"denuncia_id": "{{$solicitacao->id}}"},
                    dataType:'json',
                    success: function(denuncia){
                        var divDenuncia = document.getElementById('relato');
                        divDenuncia.innerHTML = denuncia.texto;
                    },
                });
            });
        </script>
    @endpush
    @endsection
</x-app-layout>
@endguest
