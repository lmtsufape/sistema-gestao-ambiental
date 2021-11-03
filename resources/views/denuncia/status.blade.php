<x-guest-layout>
    @component('layouts.nav_bar')@endcomponent

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Denúncia</h5>
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
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <label for="empresa">Empresa denunciada:</label>
                                    @if ($denuncia->empresa_id != null)
                                        <input id="empresa" class="form-control @error('empresa') is-invalid @enderror" type="text" name="empresa" value="{{$denuncia->empresa->nome}}" disabled autocomplete="empresa">
                                    @else
                                        <input id="empresa" class="form-control @error('empresa') is-invalid @enderror" type="text" name="empresa" value="{{$denuncia->empresa_nao_cadastrada}}" disabled autocomplete="empresa">
                                    @endif
                                </div>

                                @if ($denuncia->empresa_id == null)
                                    <div class="col-md-12">
                                        <label for="endereco">Endereço:</label>
                                        <input id="endereco" class="form-control @error('endereco') is-invalid @enderror" type="text" name="endereco" value="{{$denuncia->endereco}}" disabled autocomplete="endereco">
                                    </div>
                                @endif
                            </div>
                            @if ($denuncia->denunciante != null)
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="denunciante">Denunciante:</label>
                                        <input id="denunciante" class="form-control @error('denunciante') is-invalid @enderror" type="text" name="denunciante" value="{{$denuncia->denunciante}}" disabled autocomplete="denunciante">
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
                            @if ($denuncia->fotos->first() != null)
                                <br><div class="row">
                                    <div class="col-12" style="font-family: 'Times New Roman', Times, serif">Imagens anexadas junto a denúncia:</div>
                                </div>
                                <div class="row">
                                    @foreach ($denuncia->fotos as $foto)
                                        <div class="col-md-6">
                                            <div class="card" style="width: 100%;">
                                                <img src="{{asset('storage/' . $foto->caminho)}}" class="card-img-top" alt="...">
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
                            @if ($denuncia->videos->first() != null)
                                <br><div class="row">
                                    <div class="col-12" style="font-family: 'Times New Roman', Times, serif">Vídeos anexados junto a denúncia:</div>
                                </div>
                                <div class="row">
                                    @foreach ($denuncia->videos as $video)
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
            </div>
            <div class="col-md-4">
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom:20px">
                        <div class="card shadow" style="background-color: rgb(225, 255, 219); border-radius:12px; border-width:0px;">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12" style="margin-bottom: 0.5rem">
                                        <h5 class="card-title mb-0" style="font-family:Arial, Helvetica, sans-serif; color:#08a02e; font-weight:bold">Status da denúncia</h5>
                                    </div>
                                    <div class="col-md-12">
                                        @switch($denuncia->aprovacao)
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
    @component('layouts.footer')@endcomponent
</x-guest-layout>

<script scr="{{asset('ckeditor/ckeditor.js')}}"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{route('denuncias.get')}}",
            method: 'get',
            type: 'get',
            data: {"denuncia_id": "{{$denuncia->id}}"},
            dataType:'json',
            success: function(denuncia){
                var divDenuncia = document.getElementById('relato');
                divDenuncia.innerHTML = denuncia.texto;
            },
        });
    });
</script>
