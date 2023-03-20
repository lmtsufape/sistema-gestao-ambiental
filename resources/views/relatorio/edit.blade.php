<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        @if ($relatorio->visita->requerimento != null)
                            <h4 class="card-title">Editar relátorio do requerimento nº {{$relatorio->visita->requerimento->id}}</h4>
                        @elseif ($relatorio->visita->denuncia != null)
                            <h4 class="card-title">Editar relátorio da denúncia nº {{$relatorio->visita->denuncia->id}}</h4>
                        @elseif ($relatorio->visita->solicitacaoPoda != null)
                            <h4 class="card-title">Editar relátorio da solicitação de poda/supressão nº {{$relatorio->visita->solicitacaoPoda->id}}</h4>
                        @endif
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('visitas.index', ['filtro' => 'requerimento', 'ordenacao' => 'data_marcada', 'ordem' => 'DESC'])}}">Programação</a> > Visitas > Editar relátorio</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right">
                        {{-- <a title="Voltar" href="{{route('visitas.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form col-md-12" style="margin-top:10px;">
                                @if ($relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'])
                                    <div class="alert alert-success" role="alert">
                                        <h4 class="alert-heading">Relatório aprovado!</h4>
                                        <hr>
                                        <p class="mb-0">Este relatório já foi aprovado! As edições estão desativadas.</p>
                                    </div>
                                @elseif($relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['reprovado'])
                                    <div class="alert alert-warning" role="alert">
                                        <h4 class="alert-heading">Necessária revisão</h4>
                                        <hr>
                                        <p class="mb-0">{{$relatorio->motivo_edicao}}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form col-md-9" style="margin-top:10px;">
                                <form id="form-relatorio-visita" method="POST" action="{{route('relatorios.update', ['relatorio' => $relatorio->id])}}">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="visita" value="{{$relatorio->visita_id}}">
                                    <textarea id="relatorio" name="texto">{{$relatorio->texto}}</textarea>
                                    <div class="form-row justify-content-between">
                                        <div class="col-md-8">
                                            <label for="imagem">{{ __('Imagens anexadas') }}</label>
                                        </div>
                                        <div class="col-md-4" style="text-align: right">
                                            <input type="hidden" id="imagem_indice" value="-1">
                                            <a title="Adicionar imagem" id="btn-add-imagem" onclick="addImagem()" style="cursor: pointer;">
                                                <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar imagem">
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="hidden" id="tamanhoTotal" value="0">
                                        <div id="imagens" class="form-row">
                                            {{-- style="width:100%; height:300px; overflow:auto;" --}}
                                            <div class="col-md-4">
                                                <div>
                                                    <label for="file-input-imagem_indice">
                                                        <img id="imagem_previaimagem_indice" class="img-fluid" src="{{asset('/img/nova_imagem.PNG')}}" alt="imagem de anexo" style="cursor: pointer;"/>
                                                    </label>
                                                    <input style="display: none;" type="file" name="imagem[]" id="file-input-imagem_indice" accept="image/*" onchange="loadPreview(event, 'imagem_indice')">
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col-md-6" style="text-align: right">
                                                        <div id="nomeimagem_indice" style="display: none; font-style: italic;"></div>
                                                    </div>
                                                    <div class="col-md-6" style="text-align: right">
                                                        <a style="cursor: pointer; color: #ec3b3b; font-weight: bold;" onclick="this.parentElement.parentElement.parentElement.remove()">remover</a>
                                                    </div>
                                                </div>
                                            </div>
            
                                            @if ($errors->has('imagem.*') && $errors->has('comentario.*'))
                                                @foreach ($errors->get('imagem.*') as $i => $images)
                                                    @foreach ($images as $b => $opcao)
                                                        <div class="col-md-4" style="margin: 10px 10px 0 0;">
                                                            <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                            <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                            @error('imagem.*'.$b)
                                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                                    {{ $opcao }}
                                                                </div>
                                                            @enderror
                                                    @endforeach
                                                @endforeach
                                                @foreach ($errors->get('comentario.*') as $i => $comentarios)
                                                    @foreach ($comentarios as $b => $opcao)
                                                            <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                            <input type="text" class="form-control @error('comentario.'.$b) is-invalid @enderror" name="comentario[]" id="comentario">
                                                            @error('comentario.'.$b)
                                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                                    {{ $opcao }}
                                                                </div>
                                                            @enderror
                                                            <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            @else
                                                @if($errors->has('imagem.*'))
                                                    @foreach ($errors->get('imagem.*') as $i => $images)
                                                        @foreach ($images as $b => $opcao)
                                                            <div class="col-md-4" style="margin: 10px 10px 0 0;">
                                                                <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                                <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                                @error('imagem.*'.$b)
                                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                                        {{ $opcao }}
                                                                    </div>
                                                                @enderror
                                                                <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}</label>
                                                                <input type="text" class="form-control" name="comentario[]" id="comentario">
                                                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    @foreach ($errors->get('comentario.*') as $i => $comentarios)
                                                        @foreach ($comentarios as $b => $opcao)
                                                            <div class="col-md-4" style="margin: 10px 10px 0 0;">
                                                                <label for="imagem">{{ __('Selecione a imagem') }}</label>
                                                                <input type="file" class="@error('imagem.'.$b) is-invalid @enderror" name="imagem[]" id="imagem" accept="image/*">
                                                                <label for="comentarios" style="margin-right: 10px;">{{ __('Comentário') }}     </label>
                                                                <input type="text" class="form-control @error('comentario.'.$b) is-invalid @enderror" name="comentario[]" id="comentario">
                                                                @error('comentario.'.$b)
                                                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                                                        {{ $opcao }}
                                                                    </div>
                                                                @enderror
                                                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger" style="margin-top: 10px;">Remover imagem</button>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="customFilearquivo">Arquivo anexado</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" accept="application/pdf" id="customFilearquivo" name="arquivoFile" lang="pt">
                                            <label class="custom-file-label" for="customFilearquivo">Selecione um arquivo</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form col-md-3">
                                <div class="col barraMenu">
                                    <p style="margin-top:8px; margin-bottom:6px;">Álbum</p>
                                </div>
                                <div class=" overflow-auto" style="padding-left: 15px; padding-top:10px;">
                                    <table class="table table-borderless table-hover">
                                        <tbody>
                                        {{-- @foreach ($album as $item)
                                            @if($item->orientation == 6 || $item->orientation == 8)
                                            <tr style="text-align: center;border: 1.5px solid #f5f5f5;">
                                                <td style="width: 100%;" type="button" data-toggle="modal" data-target="#modaTipo1{{$item->id}}"><img src="{{asset('/imagens/inspecoes/'.$item->imagemInspecao)}}" alt="Logo" height="90px"/></td>
                                            </tr>
                                            <!-- Modal TIPO 1-->
                                            <div class="modal fade" id="modaTipo1{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Imagem</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-3">
                                                                <img src="{{asset('/imagens/inspecoes/'.$item->imagemInspecao)}}" alt="Logo" height="290px"/>
                                                            </div>
                                                            <div class="form-group col-md-9">
                                                                <div style="overflow: auto; height:290px;">
                                                                    <label>{!! $item->descricao !!}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-dismiss="modal" style="width: 190px;">Fechar</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <!--x Modal x-->
                                            @else
                                            <tr style="text-align: center;border: 1.5px solid #f5f5f5;">
                                                <td style="width: 100%;"  type="button" data-toggle="modal" data-target="#modaTipo2{{$item->id}}"><img src="/imagens/inspecoes/{{$item->imagemInspecao}}" alt="Logo" height="90px"/></td>
                                            </tr>
                                            <!-- Modal TIPO 2-->
                                            <div class="modal fade" id="modaTipo2{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Imagem</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <img src="/imagens/inspecoes/{{$item->imagemInspecao}}" alt="Logo" height="190px"/>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <div style="overflow: auto; height:195px;">
                                                                    <label>{!! $item->descricao !!}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-dismiss="modal" style="width: 190px;">Fechar</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <!--x Modal x-->
                                            @endif
                                        @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    @if($relatorio->aprovacao != \App\Models\Relatorio::APROVACAO_ENUM['aprovado'])
                        <div class="card-footer">
                            <div class="form-row">
                                <div class="col-md-6 form-group"></div>
                                <div class="col-md-6 form-group">
                                    <button class="btn btn-success btn-color-dafault  submeterFormBotao" style="width: 100%;" form="form-relatorio-visita" @if($relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado']) disabled @endif>Atualizar</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push ('scripts')
        <script>
            CKEDITOR.replace('relatorio');

                $('#customFilearquivo').change(function(e){
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
            });
            var $videoId = 1;
            CKEDITOR.replace('denuncia-ckeditor', {
            height: 400
            });

            function addImagem() {
            if($('#imagens').children().length >= 20){
                alert("A quantidade máxima de imagens é 20!");
            }else{
                var indice = document.getElementById("imagem_indice");
                var imagem_indice = parseInt(document.getElementById("imagem_indice").value)+1;
                indice.value = imagem_indice;

                var campo_imagem = `<div class="col-md-4">
                                        <div class="">
                                            <label for="file-input-`+imagem_indice+`">
                                                <img id="imagem_previa`+imagem_indice+`" class="img-fluid" src="{{asset('/img/nova_imagem.PNG')}}" alt="imagem de anexo" style="cursor: pointer;"/>
                                            </label>
                                            <input style="display: none;" type="file" name="imagem[]" id="file-input-`+imagem_indice+`" accept="image/*" onchange="loadPreview(event, `+imagem_indice+`)">
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <div class="col-md-6" style="text-align: right">
                                                <div id="nome`+imagem_indice+`" style="display: none; font-style: italic;"></div>
                                            </div>
                                            <div class="col-md-6" style="text-align: right">
                                                <a style="cursor: pointer; color: #ec3b3b; font-weight: bold;" onclick="removerImagem(this, `+imagem_indice+`)">remover</a>
                                            </div>
                                        </div>
                                        {{--<div class="form-row">
                                            <label for="comentarios"">{{ __('Comentário') }}</label>
                                            <textarea type="text" class="form-control" name="comentario[]" id="comentario"></textarea>
                                        </div>--}}
                                    </div>`;

                $('#imagens').append(campo_imagem);
                $("#file-input-"+imagem_indice).click();
            }
            }

            function removerImagem(image, id){
                let imagem = $('#file-input-'+id);
                if(imagem[0].files[0]){
                    let total = document.getElementById('tamanhoTotal');
                    total.value = parseInt(total.value) - imagem[0].files[0].size;
                }
                image.parentElement.parentElement.parentElement.remove();
            }

    
            var loadPreview = function(event, indice) {
                if(checarTamanhoIndividual(indice) && checarTamanhoTotal(indice)){
                    var reader = new FileReader();
                    reader.onload = function(){
                    var output = document.getElementById('imagem_previa'+indice);
                        output.src = reader.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                    document.getElementById('nome'+indice).innerHTML = event.target.files[0].name;
                    document.getElementById('nome'+indice).style.display = "block";
                }
            };

            function checarTamanhoIndividual(id){
                let imagem = $('#file-input-'+id);
                if(imagem[0].files[0]){
                    const fileSize = imagem[0].files[0].size / 1024 / 1024;
                    if(fileSize > 2){
                        alert("A imagem deve ter no máximo 2MB!");
                        imagem.value = "";
                        imagem[0].parentElement.parentElement.remove();
                        return false;
                    }
                }
                return true;
            };

            function checarTamanhoTotal(id){
                let total = document.getElementById('tamanhoTotal');
                console.log(total.value);
                let imagem = $('#file-input-'+id);
                if(imagem[0].files[0]){
                    const fileSize = imagem[0].files[0].size / 1024 / 1024;
                    const totalSize = parseInt(total.value) / 1024 / 1024;
                    if(totalSize+fileSize > 8){
                        alert("A soma dos tamanhos da imagem não deve ultrapassar 8MB!");
                        imagem.value = "";
                        imagem[0].parentElement.parentElement.remove();
                        return false;
                    }
                }
                total.value = parseInt(total.value) + imagem[0].files[0].size;
                return true;
            };
            
        </script>
    @endpush
    @endsection
</x-app-layout>
