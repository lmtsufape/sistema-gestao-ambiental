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
                                <h5 class="card-title">Editar relátorio do requerimento nº {{$relatorio->visita->requerimento->id}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Programação > Relátorio</h6>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form col-md-12" style="margin-top:10px;">
                                @if ($relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'])
                                    <div class="alert alert-success" role="alert">
                                        <h4 class="alert-heading">Relatório aprovado</h4>
                                        <hr>
                                        <p class="mb-0">Esse relatório já foi aprovado, logo edições estão desativadas.</p>
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
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6 form-group"></div>
                            <div class="col-md-6 form-group">
                                <button class="btn btn-success" style="width: 100%;" form="form-relatorio-visita" @if($relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado']) disabled @endif>Atualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('relatorio');
    </script>
</x-app-layout>