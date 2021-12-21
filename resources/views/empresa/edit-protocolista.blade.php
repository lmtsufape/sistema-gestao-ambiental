<x-app-layout>
    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Editar a empresa/serviço {{$requerimento->empresa->nome}} como protocolista</h4>
                        <h6 class="card-subtitle mb-2 text-muted">Requerimentos > Visualizar requerimento  nº {{$requerimento->id}} > Editar empresa/serviço do requerimento</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        <a title="Voltar" href="{{route('requerimentos.show', $requerimento)}}">
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
                        @if(session('error'))
                            <div class="col-md-12" style="margin-top: 5px;">
                                <div class="alert alert-danger" role="alert">
                                    <p>{{session('error')}}</p>
                                </div>
                            </div>
                        @endif
                        <form method="POST" id="editar-empresa" action="{{route('requerimentos.update.empresa', $requerimento->id)}}">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label for="porte">{{ __('Porte') }}</label> <a href="{{route('info.porte')}}" title="Como classificar o porte?" target="_blanck"><img src="{{asset('img/interrogacao.png')}}" alt="Como definir o porte?" style="width: 15px; display: inline; padding-bottom: 5px;"></a>
                                        <select id="porte" class="form-control @error('porte') is-invalid @enderror" type="text" name="porte" required autofocus autocomplete="porte">
                                            @if(old('porte') != null)
                                                <option value="">-- Selecionar o porte da empresa --</option>
                                                <option @if(old('porte') == \App\Models\Empresa::PORTE_ENUM['micro']) selected @endif value="micro">Micro</option>
                                                <option @if(old('porte') == \App\Models\Empresa::PORTE_ENUM['pequeno']) selected @endif value="pequeno">Pequeno</option>
                                                <option @if(old('porte') == \App\Models\Empresa::PORTE_ENUM['medio']) selected @endif value="medio">Médio</option>
                                                <option @if(old('porte') == \App\Models\Empresa::PORTE_ENUM['grande']) selected @endif value="grande">Grande</option>
                                                <option @if(old('porte') == \App\Models\Empresa::PORTE_ENUM['especial']) selected @endif value="especial">Especial</option>
                                            @else
                                                <option @if($requerimento->empresa->porte == \App\Models\Empresa::PORTE_ENUM['micro']) selected @endif value="micro">Micro</option>
                                                <option @if($requerimento->empresa->porte == \App\Models\Empresa::PORTE_ENUM['pequeno']) selected @endif value="pequeno">Pequeno</option>
                                                <option @if($requerimento->empresa->porte == \App\Models\Empresa::PORTE_ENUM['medio']) selected @endif value="medio">Médio</option>
                                                <option @if($requerimento->empresa->porte == \App\Models\Empresa::PORTE_ENUM['grande']) selected @endif value="grande">Grande</option>
                                                <option @if($requerimento->empresa->porte == \App\Models\Empresa::PORTE_ENUM['especial']) selected @endif value="especial">Especial</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-12" >
                                                <label for="setor">{{ __('Tipologia') }}</label>
                                                <select required class="form-control @error('setor') is-invalid @enderror  @error('cnaes_id') is-invalid @enderror
                                                        @error('cnaes_id.*') is-invalid @enderror" id="idSelecionarSetor" onChange="selecionarSetor(this)" name="setor">
                                                    <option value="">-- Selecionar a Tipologia --</option>
                                                    @foreach ($setores as $setor)
                                                        <option @if($requerimento->empresa->cnaes()->first()->setor->id == $setor->id) selected @endif value={{$setor->id}}>{{$setor->nome}}</option>
                                                    @endforeach
                                                </select>

                                                @error('setor')
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                @error('cnaes_id')
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                @error('cnaes_id.*')
                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="btn-group col-md-12">
                                                <div class="col-md-6 styleTituloDoInputCadastro" style="margin-left:-15px;margin-right:30px;margin-bottom:10px;">Lista de CNAE</div>
                                                <div class="col-md-12 input-group input-group-sm mb-2"></div>
                                            </div>
                                            <div class="form-row col-md-12">
                                                <div style="width:100%; height:250px; display: inline-block; border: 1.5px solid #f2f2f2; border-radius: 2px; overflow:auto;">
                                                    <table id="tabelaCnaes" cellspacing="0" cellpadding="1"width="100%" >
                                                        <tbody id="dentroTabelaCnaes"></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="styleTituloDoInputCadastro" for="exampleFormControlSelect1">CNAE selecionado</label>
                                        <div class="form-group col-md-12 areaMeusCnaes" id="listaCnaes">
                                            @foreach ($requerimento->empresa->cnaes as $cnae)
                                                <div id="cnaeCard_{{$cnae->setor->id}}_{{$cnae->id}}" class="d-flex justify-content-center card-cnae" onmouseenter="mostrarBotaoAdicionar({{$cnae->id}})">
                                                    <div class="mr-auto p-2" id="{{$cnae->id}}">{{$cnae->nome}}</div>
                                                    <div style="width:140px; height:25px; text-align:right;">
                                                        <div id="cardSelecionado{{$cnae->id}}" class="btn-group" style="display:none;">
                                                            <div id="botaoCardSelecionado{{$cnae->id}}" class="btn btn-danger btn-sm"  onclick="add_Lista({{$cnae->setor->id}}, {{$cnae->id}})" >Remover</div>
                                                        </div>
                                                    </div>
                                                    <input id ="inputCnae_{{$cnae->id}}" hidden name="cnaes_id[]" value="{{$cnae->id}}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" class="btn btn-success submeterFormBotao" form="editar-empresa" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function($) {
        selecionarSetor();
    });
    
    window.selecionarSetor = function(){
        //setor
        var historySelectList = $('select#idSelecionarSetor');
        var $setor_id = $('option:selected', historySelectList).val();
        limparLista()
        $.ajax({
            url:'setor/ajax-listar-cnaes',
            type:"get",
            data: {"setor_id": $setor_id},
            dataType:'json',
            /*success: function(response){
                console.log(response.responseJSON);
                for(var i = 0; i < data.responseJSON.cnaes.length; i++){
                    var html = data.responseJSON.cnaes[i];
                    $('#tabelaCnaes tbody').append(html);
                }
            },*/

            complete: function(data) {
                if(data.responseJSON.success){
                    for(var i = 0; i < data.responseJSON.cnaes.length; i++){
                        var naLista = document.getElementById('listaCnaes');
                        var html = `<div id="cnaeCard_`+$setor_id+`_`+data.responseJSON.cnaes[i].id+`" class="d-flex justify-content-center card-cnae" onmouseenter="mostrarBotaoAdicionar(`+data.responseJSON.cnaes[i].id+`)">
                                        <div class="mr-auto p-2" id="`+data.responseJSON.cnaes[i].id+`">`+data.responseJSON.cnaes[i].nome+`</div>
                                        <div style="width:140px; height:25px; text-align:right;">
                                            <div id="cardSelecionado`+data.responseJSON.cnaes[i].id+`" class="btn-group" style="display:none;">
                                                <div id="botaoCardSelecionado`+data.responseJSON.cnaes[i].id+`" class="btn btn-success btn-sm"  onclick="add_Lista(`+$setor_id+`, `+data.responseJSON.cnaes[i].id+`)" >Adicionar</div>
                                            </div>
                                        </div>
                                    </div>`;
                        if(document.getElementById('cnaeCard_'+$setor_id+'_'+data.responseJSON.cnaes[i].id) == null){
                            $('#tabelaCnaes tbody').append(html);
                        }
                    }
                }
            }
        });
    }

    window.add_Lista = function($setor, $id) {
        var elemento = document.getElementById('cnaeCard_'+$setor+'_'+$id);
        var naTabela = document.getElementById('dentroTabelaCnaes');
        var divBtn = elemento.children[1].children[0].children[0];

        if(elemento.parentElement == naTabela){
            $('#listaCnaes').append(elemento);
            divBtn.style.backgroundColor = "#dc3545";
            divBtn.style.borderColor = "#dc3545";
            divBtn.textContent = "Remover";
            var html = `<input id ="inputCnae_`+$id+`" hidden name="cnaes_id[]" value="`+$id+`">`;
            $('#cnaeCard_'+$setor+'_'+$id).append(html);
        }else{
            var historySelectList = $('select#idSelecionarSetor');
            var $setor_id = $('option:selected', historySelectList).val();
            if($setor == $setor_id){
                $('#dentroTabelaCnaes').append(elemento);
                divBtn.style.backgroundColor = "#28a745";
                divBtn.style.borderColor = "#28a745";
                divBtn.textContent = "Adicionar";
                $('#inputCnae_'+$id).remove();
            }else{
                document.getElementById('listaCnaes').removeChild(elemento);
            }
        }

    }

    var tempIdCard = -1;
    window.mostrarBotaoAdicionar = function(valor){
        if(tempIdCard == -1){
            document.getElementById("cardSelecionado"+valor).style.display = "block";
            this.tempIdCard=document.getElementById("cardSelecionado"+valor);
        }else if(tempIdCard != -1){
            tempIdCard.style.display = "none";
            document.getElementById("cardSelecionado"+valor).style.display = "block";
            this.tempIdCard=document.getElementById("cardSelecionado"+valor);

        }

    }

    function limparLista() {
        var cnaes = document.getElementById('tabelaCnaes').children[0];
        cnaes.innerHTML = "";
    }
</script>
