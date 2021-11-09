<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar relatório') }}
        </h2>
    </x-slot>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-center">
            <div class="col-md-10">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-8">
                                @if ($relatorio->visita->requerimento != null)
                                    <h5 class="card-title">Editar relátorio do requerimento nº {{$relatorio->visita->requerimento->id}}</h5>
                                @elseif ($relatorio->visita->denuncia != null)
                                    <h5 class="card-title">Cria relátorio da denúncia nº {{$relatorio->visita->denuncia->id}}</h5>
                                @endif
                                <h6 class="card-subtitle mb-2 text-muted">Programação > Relátorio</h6>
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
                            <div class="form col-md-9" style="margin-top:10px;">
                                <textarea id="relatorio" name="texto" disabled>{{$relatorio->texto}}</textarea>
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
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <button class="btn btn-warning" style="width: 100%;" data-toggle="modal" data-target="#staticBackdrop-reprovar-relatorio" {{$relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['reprovado'] ? 'disabled' : '' }}> {{$relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['reprovado'] ? 'Revisar' : 'Revisar' }}</button>
                            </div>
                            <div class="col-md-6 form-group">
                                <button class="btn btn-success" style="width: 100%;" data-toggle="modal" data-target="#staticBackdrop-aprovar-relatorio" {{$relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'] ? 'disabled' : '' }}> {{$relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'] ? 'Aprovado' : 'Aprovar' }} </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop-aprovar-relatorio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #28a745;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Aprovar relátorio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-relatorio-aprovar" method="POST" action="{{route('relatorios.resultado', ['relatorio' => $relatorio->id])}}">
                        @csrf
                        <input type="hidden" name="aprovacao" value="1">
                        Tem certeza que deseja aprovar esse relátorio?
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="submeterFormBotao" class="btn btn-success" form="form-relatorio-aprovar">Aprovar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop-reprovar-relatorio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #e0a800;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Revisar relátorio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-relatorio-reprovar" method="POST" action="{{route('relatorios.resultado', ['relatorio' => $relatorio->id])}}">
                        @csrf
                        <input type="hidden" name="aprovacao" value="0">
                        <div class="form-row">
                            <div class="col-md-12">
                                Tem certeza que deseja mandar esse relátorio para revisão?
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="motivo">Motivo da revisão</label>
                                <textarea class="form-control" name="motivo" id="motivo" cols="30" rows="5" placeholder="Digite aqui..."></textarea>

                                @error('motivo')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="submeterFormBotao" class="btn btn-warning" form="form-relatorio-reprovar">Revisar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('relatorio');
    </script>
</x-app-layout>
