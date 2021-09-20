<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Denúncias') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                <h5 class="card-title">Denúncias cadastrados no sistema</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Denúncias</h6>
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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="denuncias-pendentes-tab" data-toggle="tab" href="#denuncias-pendentes"
                                    type="button" role="tab" aria-controls="denuncias-pendentes" aria-selected="true">Pendentes</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="denuncias-aprovadas-tab" data-toggle="tab" role="tab" type="button" 
                                    aria-controls="denuncias-aprovadas" aria-selected="false" href="#denuncias-aprovadas">Aprovadas</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" type="button" id="denuncias-arquivadas-tab" data-toggle="tab" role="tab" 
                                    aria-controls="denuncias-arquivadas" aria-selected="false" href="#denuncias-arquivadas">Arquivadas</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="denuncias-pendentes" role="tabpanel" aria-labelledby="denuncias-pendentes-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center">Empresa</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($denuncias_registradas as $denuncia)
                                            <tr>
                                                <td style="text-align: center">{{ $denuncia->empresa_id ? $denuncia->empresa->nome : $denuncia->empresa_nao_cadastrada }}</td>
                                                <td style="text-align: center">
                                                    {{ $denuncia->empresa_id ? $denuncia->empresa->endereco->enderecoSimplificado() : $denuncia->endereco }}
                                                </td>
                                                <td style="text-align: center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-light dropdown-toggle shadow-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <img class="filter-green" src="{{asset('img/icon_acoes.svg')}}" style="width: 4px;">
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;" 
                                                                onclick="denuncia('{{$denuncia->texto}}')" data-toggle="modal" data-target="#exampleModalCenter">Descrição</button>
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;" 
                                                                onclick="denunciaId('{{$denuncia->id}}')" data-toggle="modal" data-target="#exampleModalLabelB">Avaliar</button>
                                                           <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;" 
                                                                onclick="abrirImagens('{{$denuncia->id}}')" data-toggle="modal" data-target="#exampleModalLabelC">Imagens</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="denuncias-aprovadas" role="tabpanel" aria-labelledby="denuncias-aprovadas-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center">Empresa</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($denuncias_aprovadas as $denuncia)
                                            <tr>
                                                <td style="text-align: center">{{ $denuncia->empresa_id ? $denuncia->empresa->nome : $denuncia->empresa_nao_cadastrada }}</td>
                                                <td style="text-align: center">
                                                    {{ $denuncia->empresa_id ? $denuncia->empresa->endereco->enderecoSimplificado() : $denuncia->endereco }}
                                                </td>
                                                <td style="text-align: center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-light dropdown-toggle shadow-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <img class="filter-green" src="{{asset('img/icon_acoes.svg')}}" style="width: 4px;">
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;" 
                                                                onclick="denuncia('{{$denuncia->texto}}')" data-toggle="modal" data-target="#exampleModalCenter">Descrição</button>
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;" 
                                                                onclick="denunciaId('{{$denuncia->id}}')" data-toggle="modal" data-target="#exampleModalLabelB">Avaliar</button>
                                                           <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;" 
                                                                onclick="abrirImagens('{{$denuncia->id}}')" data-toggle="modal" data-target="#exampleModalLabelC">Imagens</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="denuncias-arquivadas" role="tabpanel" aria-labelledby="denuncias-arquivadas-tab">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="text-align: center">Empresa</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($denuncias_arquivadas as $denuncia)
                                            <tr>
                                                <td style="text-align: center">{{ $denuncia->empresa_id ? $denuncia->empresa->nome : $denuncia->empresa_nao_cadastrada }}</td>
                                                <td style="text-align: center">
                                                    {{ $denuncia->empresa_id ? $denuncia->empresa->endereco->enderecoSimplificado() : $denuncia->endereco }}
                                                </td>
                                                <td style="text-align: center">
                                                    <div class="dropdown">
                                                        <button class="btn btn-light dropdown-toggle shadow-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <img class="filter-green" src="{{asset('img/icon_acoes.svg')}}" style="width: 4px;">
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;" 
                                                                onclick="denuncia('{{$denuncia->texto}}')" data-toggle="modal" data-target="#exampleModalCenter">Descrição</button>
                                                            <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;" 
                                                                onclick="denunciaId('{{$denuncia->id}}')" data-toggle="modal" data-target="#exampleModalLabelB">Avaliar</button>
                                                           <button type="button" class="btn btn-primary btn-sm dropdown-item" style="font-size:15px;" 
                                                                onclick="abrirImagens('{{$denuncia->id}}')" data-toggle="modal" data-target="#exampleModalLabelC">Imagens</button>
                                                        </div>
                                                    </div>
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
        </div>
    </div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2a9df4;">
                    <img src="{{ asset('img/logo_atencao3.png') }}" width="30px;" alt="Logo" style=" margin-right:15px; margin-top:10px;"/>
                        <h5 class="modal-title" id="exampleModalLabel2" style="font-size:20px; margin-top:7px; color:white; 
                            font-weight:bold; font-family: 'Roboto', sans-serif;">
                            Descrição
                        </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formRequerimento" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div id="avisoReq" class="col-12" style="font-family: 'Roboto', sans-serif; margin-bottom:10px;">Relato descrito pelo denunciante:</div>
                        <div class="col-12"><textarea name="modalDenuncia" class="denuncia-ckeditor" value="" disabled></textarea></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="exampleModalLabelC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelC" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2a9df4;">
                    <img src="{{ asset('img/logo_atencao3.png') }}" alt="Logo" style=" margin-right:15px;"/>
                        <h5 class="modal-title" style="font-size:20px; color:white; font-weight:bold; font-family: 'Roboto', sans-serif;">
                            Imagens da Denúncia
                        </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" style="font-family: 'Roboto', sans-serif;">Imagens anexadas junto a denúncia:</div>
                </div>
                <div id="tbody_imagens"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalLabelB" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelB" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#2a9df4;">
                    <img src="{{ asset('img/logo_atencao3.png') }}" alt="Logo" style=" margin-right:15px;"/>
                        <h5 class="modal-title" style="font-size:20px; color:white; font-weight:bold; 
                            font-family: 'Roboto', sans-serif;">
                        Avaliar Denúncia
                    </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12" style="font-family: 'Roboto', sans-serif;">
                        Você deseja aprovar ou arquivar esta denúncia 
                        <label id="nomeDoEstabelecimento" style="font-weight:bold; font-family: 'Roboto', sans-serif;"></label>?
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('denuncias.avaliar') }}">
                    @csrf
                    <input type="hidden" name="denunciaId" id="denunciaId" value="">
                    <div class="form-row">
                        <div class="col-md-6 form-group" style="padding-right: 20px">
                            <button type="submit" class="btn btn-success botao-form" style="width:100%"
                                name="aprovar" value="true">Aprovar</button>
                        </div>
                        <div class="col-md-6 form-group">
                            <button type="submit" class="btn btn-danger botao-form" style="width:100px;"
                                name="aprovar" value="false">Arquivar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var editorCkeditor = null;

    ClassicEditor
        .create(document.querySelector( '.denuncia-ckeditor' ))
        .then(editor => {   
            editor.isReadOnly = true;
            editorCkeditor = editor;
        } )
        .catch(error => {
            console.error( error );
        } );

    window.denuncia = function(descricao){
        editorCkeditor.setData(descricao);
    }

    window.abrirImagens = function(id){
        $.ajax({
            url:'/denuncias/imagens',
            type:"get",
            dataType:'json',
            data: {"id": id },
            success: function(response){
                caminho = '<img style="margin-top: 10px; margin-bottom: 10px;" src="{{asset("storage/$")}}">';
                var element = document.getElementById('tbody_imagens');
                element.innerHTML = "";
                for (let index = 0; index < response.table_data.length; index++) {
                    resultado = caminho.replace("$", response.table_data[index]);
                    element.innerHTML += resultado;   
                }
            }
        });        
    }

    window.denunciaId = function(id){
        document.getElementById("denunciaId").value = id;
    }
</script>
</x-app-layout>