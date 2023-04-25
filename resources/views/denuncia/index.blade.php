<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-between">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Denúncias @if($filtro == "concluidas") com relatório aprovado @else {{$filtro}} @endif</h4>
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

                <form action="{{route('denuncias.index', $filtro)}}" method="get">
                    @csrf
                    <div class="form-row mb-3">
                        <div class="col-md-7">
                            <input type="text" class="form-control w-100" name="buscar" placeholder="Digite o nome da Empresa" value="{{ $busca }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn" style="background-color: #00883D; color: white;">Buscar</button>
                        </div>
                    </div>
                </form>

                <ul class="nav nav-tabs nav-tab-custom" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'pendentes') active @endif" id="denuncias-pendentes-tab"
                            type="button" role="tab" @if($filtro == 'pendentes') aria-selected="true" @endif href="{{route('denuncias.index', 'pendentes')}}">Pendentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'deferidas') active @endif" id="denuncias-aprovadas-tab"
                            type="button" role="tab" @if($filtro == 'deferidas') aria-selected="true" @endif href="{{route('denuncias.index', 'deferidas')}}">Deferidas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'concluidas') active @endif" id="denuncias-concluidas-tab"
                            type="button" role="tab" @if($filtro == 'concluidas') aria-selected="true" @endif href="{{route('denuncias.index', 'concluidas')}}">Concluídas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($filtro == 'indeferidas') active @endif" id="denuncias-arquivadas-tab"
                            type="button" role="tab" @if($filtro == 'indeferidas') aria-selected="true" @endif href="{{route('denuncias.index', 'indeferidas')}}">Indeferidas</a>
                    </li>
                </ul>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="tab-content tab-content-custom" id="myTabContent">
                            <div class="tab-pane fade show active" id="denuncias-pendentes" role="tabpanel" aria-labelledby="denuncias-pendentes-tab">
                                <div class="table-responsive">
                                <table class="table mytable" id="denucias-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Data de requerimento</th>
                                            <th scope="col" style="text-align: center">Empresa/serviço</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Analista</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($denuncias as $i => $denuncia)
                                            <tr>
                                                <th>{{ ($denuncias->currentpage()-1) * $denuncias->perpage() + $loop->index + 1 }}</th>
                                                <td>{{date('d/m/Y H:i', strtotime($denuncia->created_at))}}</td>
                                                <td style="text-align: center">{{ $denuncia->empresa_id ? $denuncia->empresa->nome : $denuncia->empresa_nao_cadastrada }}</td>
                                                <td style="text-align: center">
                                                    {{ $denuncia->empresa_id ? $denuncia->empresa->endereco->enderecoSimplificado() : $denuncia->endereco }}
                                                </td>
                                                <td style="text-align: center">{{$denuncia->analista_id ? $denuncia->analista->name : ''}}</td>
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        <a data-toggle="modal" data-target="#modal-texto-{{$denuncia->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Descrição"></a>
                                                        @can('isSecretario', \App\Models\User::class)
                                                            <a id="btn-avaliar-{{$denuncia->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"
                                                                data-toggle="modal" data-target="#modal-avaliar-{{$denuncia->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Avaliação.svg')}}"  alt="Avaliar"></a>
                                                        @endcan
                                                        @can('isSecretario', \App\Models\User::class)
                                                            @if($filtro != "indeferidas" && $filtro != "pendentes")
                                                                <a data-toggle="modal" data-target="#modal-atribuir" onclick="adicionarIdAtribuir({{$denuncia->id}})" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  class="icon-licenciamento" width="20px;"src="{{asset('img/Atribuir analista.svg')}}"  alt="Atribuir a um analista"></a>
                                                            @endif
                                                            @if($filtro != "indeferidas" && $filtro != "pendentes")
                                                                <a class="icon-licenciamento" title="Agendar visita" id="btn-criar-visita-{{$denuncia->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"
                                                                    data-toggle="modal" @if($denuncia->visita)  data-target="#modal-agendar-visita-editar" onclick="adicionarIdEditar({{$denuncia->id}})" @else  data-target="#modal-agendar-visita"  onclick="adicionarId({{$denuncia->id}})" @endif><img class="icon-licenciamento" width="20px;" src="{{asset('img/Agendar.svg')}}"  alt="Agendar uma visita"></a>
                                                            @endif
                                                        @endcan
                                                        @can('isSecretario', \App\Models\User::class)
                                                            @if($filtro ==  "concluidas")
                                                                @if($denuncia->visita->relatorio!=null)<a title="Relatório" href="{{route('relatorios.show', ['relatorio' => $denuncia->visita->relatorio])}}"><img class="icon-licenciamento"
                                                                @if($denuncia->visita->relatorio->aprovacao == \App\Models\Relatorio::APROVACAO_ENUM['aprovado'])
                                                                    src="{{asset('img/Relatório Aprovado.svg')}}"
                                                                @else
                                                                    src="{{asset('img/Relatório Sinalizado.svg')}}"
                                                                @endif alt="Icone de relatório"></a>@endif
                                                            @endif
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @if($denuncias->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma denúncia @switch($filtro) @case('pendentes')pendente @break @case('deferidas')deferida @break @case('concluidas')concluída @break @case('indeferidas')indeferida @break @endswitch
                                    </div>
                                @endif
                            </div>
                            {{--<div class="tab-pane fade" id="denuncias-aprovadas" role="tabpanel" aria-labelledby="denuncias-aprovadas-tab">
                                <div class="table-responsive">
                                <table class="table mytable" id="denucias-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Empresa/serviço</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Analista</th>
                                            <th scope="col" style="text-align: center">Agendada</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($denuncias_aprovadas as $i => $denuncia)
                                            <tr>
                                                <td>{{($i+1)}}</td>
                                                <td style="text-align: center">{{ $denuncia->empresa_id ? $denuncia->empresa->nome : $denuncia->empresa_nao_cadastrada }}</td>
                                                <td style="text-align: center">
                                                    {{ $denuncia->empresa_id ? $denuncia->empresa->endereco->enderecoSimplificado() : $denuncia->endereco }}
                                                </td>
                                                <td style="text-align: center">{{$denuncia->analista_id ? $denuncia->analista->name : ''}}</td>
                                                <td style="text-align: center">{{$denuncia->visita ? date('d/m/Y', strtotime($denuncia->visita->data_marcada)) : ''}}</td>
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        @can('isSecretario', \App\Models\User::class)
                                                            <a data-toggle="modal" data-target="#modal-atribuir" onclick="adicionarIdAtribuir({{$denuncia->id}})" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Atribuir analista.svg')}}"  alt="Atribuir a um analista"></a>
                                                            <a id="btn-criar-visita-{{$denuncia->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"
                                                                    data-toggle="modal" data-target="#modal-agendar-visita" onclick="adicionarId({{$denuncia->id}})"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Agendar.svg')}}"  alt="Agendar uma visita"></a>
                                                        @endcan
                                                        <a data-toggle="modal" data-target="#modal-texto-{{$denuncia->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Descrição"></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @if($denuncias_aprovadas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma denúncia deferida
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="denuncias-arquivadas" role="tabpanel" aria-labelledby="denuncias-arquivadas-tab">
                                <div class="table-responsive">
                                <table class="table mytable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Empresa/serviço</th>
                                            <th scope="col" style="text-align: center">Endereço</th>
                                            <th scope="col" style="text-align: center">Analista</th>
                                            <th scope="col" style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($denuncias_arquivadas as $i => $denuncia)
                                            <tr>
                                                <td>{{($i+1)}}</td>
                                                <td style="text-align: center">{{ $denuncia->empresa_id ? $denuncia->empresa->nome : $denuncia->empresa_nao_cadastrada }}</td>
                                                <td style="text-align: center">
                                                    {{ $denuncia->empresa_id ? $denuncia->empresa->endereco->enderecoSimplificado() : $denuncia->endereco }}
                                                </td>
                                                <td style="text-align: center">{{$denuncia->analista_id ? $denuncia->analista->name : ''}}</td>
                                                <td style="text-align: center">
                                                    <div class="btn-group">
                                                        @can('isSecretario', \App\Models\User::class)
                                                            <a data-toggle="modal" data-target="#modal-atribuir" onclick="adicionarIdAtribuir({{$denuncia->id}})" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img  class="icon-licenciamento" width="20px;" src="{{asset('img/Atribuir analista.svg')}}"  alt="Atribuir a um analista"></a>
                                                            <a id="btn-criar-visita-{{$denuncia->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"
                                                                data-toggle="modal" data-target="#modal-avaliar-{{$denuncia->id}}"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Avaliação.svg')}}"  alt="Avaliar"></a>
                                                        @endcan
                                                        <a data-toggle="modal" data-target="#modal-texto-{{$denuncia->id}}" style="cursor: pointer; margin-left: 2px; margin-right: 2px;"><img class="icon-licenciamento" width="20px;" src="{{asset('img/Visualizar.svg')}}"  alt="Descrição"></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @if($denuncias_arquivadas->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhuma denúncia indeferida
                                    </div>
                                @endif
                            </div>--}}
                        </div>
                    </div>
                </div>
                <div class="form-row justify-content-center">
                    <div class="col-md-10">
                        {{$denuncias->links()}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 5.2rem;">
                    <div style="font-size: 21px;" class="tituloModal">
                        Legenda
                    </div>
                    <div class="mt-2 borda-baixo"></div>
                    <ul class="list-group list-unstyled">
                        <li>
                            @can('isSecretario', \App\Models\User::class)
                                <div title="Relato da denúncia" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Visualizar.svg')}}" alt="Relato da denúncia">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Relato da denúncia
                                    </div>
                                </div>
                                <div title="Avaliar denúncia" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Avaliação.svg')}}" alt="Avaliar denúncia">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Avaliar denúncia
                                    </div>
                                </div>
                                <div title="Atribuir denúncia a um analista" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Atribuir analista.svg')}}" alt="Atribuir a um analista">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Atribuir denúncia a um analista
                                    </div>
                                </div>
                                <div title="Agendar uma visita" class="d-flex align-items-center my-1 pt-0 pb-1">
                                    <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Agendar.svg')}}" alt="Agendar uma visita">
                                    <div style="font-size: 15px;" class="aling-middle mx-3">
                                        Agendar uma visita
                                    </div>
                                </div>
                            @endcan
                            @can('isSecretario', \App\Models\User::class)
                                @if($filtro ==  "concluidas")
                                    <li>
                                        <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                            <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Aprovado.svg')}}" alt="Visualizar relatório">
                                            <div style="font-size: 15px;" class="aling-middle mx-3">
                                                Relatório aprovado
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div title="Visualizar relatório" class="d-flex align-items-center my-1 pt-0 pb-1">
                                            <img class="icon-licenciamento aling-middle" width="20" src="{{asset('img/Relatório Sinalizado.svg')}}" alt="Visualizar relatório">
                                            <div style="font-size: 15px;" class="aling-middle mx-3">
                                                Relatório com pendências
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endcan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @foreach ($denuncias as $denuncia)
        <div class="modal fade" id="modal-texto-{{$denuncia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">
                            Descrição
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row form-row">
                            <label for="relato">{{__('Relato descrito pelo denunciante:')}}</label>
                            <div class="col-md-12 form-group">
                                <div class="texto-denuncia">
                                    {!! $denuncia->texto !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            @if ($denuncia->denunciante != null)
                                <div class="col-md-12 form-group">
                                    <label for="denunciante">{{__('Denunciante')}}</label>
                                    <input class="form-control" type="text" value="{{$denuncia->denunciante}}" disabled>
                                </div>
                            @endif
                        </div>
                        @if($denuncia->fotos->first() != null)
                            <div class="row form-row">
                                <div class="col-md-12 form-group">
                                    <label for="imagens_anexadas">{{__('Imagens anexadas:')}}</label>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            @foreach ($denuncia->fotos as $foto)
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
                        @if ($denuncia->arquivo)
                            <div class="form-row">
                                <label class="col-md-12">{{__('Arquivo anexado:')}}</label>
                                <a class="w-100 btn btn-success btn-enviar-doc" href="{{route('denuncias.arquivo', $denuncia->id)}}">
                                    <img class="icon-licenciamento" src="{{asset('img/fluent_document-arrow-down-20-regular.svg')}}" alt="Icone de download do documento" title="Download documento" width="20px;">
                                    Baixar arquivo  enviado
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="modal fade bd-example-modal-lg" id="modal-imagens-{{$denuncia->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelC" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Mídias da Denúncia
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12" style="font-family: 'Roboto', sans-serif;">Imagens anexadas:</div>
                        </div>
                        <br>
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

                        @if ($denuncia->videos->first() != null)
                            <div class="row">
                                <div class="col-12" style="font-family: 'Roboto', sans-serif;">Vídeos anexados junto a denúncia:</div>
                            </div>
                            <br>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>--}}

        <div class="modal fade" id="modal-avaliar-{{$denuncia->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-imagens-{{$denuncia->id}}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                            <h5 class="modal-title">
                                Avaliar Denúncia
                            </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if($denuncia->aprovacao == App\Models\Denuncia::APROVACAO_ENUM['arquivada'])
                                    <div class="alert alert-danger" role="alert">
                                        <p>Denúncia indeferida</p>
                                    </div>
                                @elseif($denuncia->aprovacao == App\Models\Denuncia::APROVACAO_ENUM['aprovada'])
                                    <div class="alert alert-success" role="alert">
                                        <p>Denúncia deferida</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <form id="form-avaliar-denuncia-{{$denuncia->id}}" method="POST" action="{{route('denuncias.avaliar')}}">
                            @csrf
                            <input type="hidden" name="denunciaId" id="denuncia-id-{{$denuncia->id}}" value="{{$denuncia->id}}">
                            <input type="hidden" name="aprovar" id="inputAprovar-{{$denuncia->id}}" value="">
                        </form>
                    </div>
                    @if($filtro !=  "concluidas")
                        <div class="modal-footer">
                            <div class="form-row col-md-12">
                                <p>Você deseja deferir ou indeferir esta denúncia?</p>
                            </div>
                            <div class="form-row col-md-12 justify-content-between">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-danger botao-form" style="padding-right: 20px; width:100%;" onclick="atualizarInputAprovar(false, {{$denuncia->id}})">Indeferir</button>
                                </div>
                                <div class="col-md-6" id="botaoDeferir">
                                    <button type="button" class="btn btn-success btn-color-dafault botao-form" style="width:100%" onclick="atualizarInputAprovar(true, {{$denuncia->id}})">Deferir</button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal fade" id="modal-agendar-visita" tabindex="-1" role="dialog" aria-labelledby="modal-imagens" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agendar visita para a denúncia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="alerta-agendar">
                        </div>
                    </div>
                    <form id="form-criar-visita-denuncia" method="POST" action="{{route('denuncias.visita.create')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="data">{{__('Data da visita')}}<span style="color: red; font-weight: bold;">*</span></label>
                                <input type="date" name="data" id="data" class="form-control @error('data') is-invalid @enderror" required value="{{old('data')}}">

                                @error('data')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                 <input type="hidden" name="denuncia_id" id="denuncia_id" value="">
                                <label for="analista">{{__('Selecione o analista da visita')}}<span style="color: red; font-weight: bold;">*</span></label>
                                <select name="analista" id="analista-visita" class="form-control @error('analista') is-invalid @enderror" required>
                                    <option value="" selected disabled>-- {{__('Selecione o analista da visita')}} --</option>
                                    @foreach ($analistas as $analista)
                                        <option @if(old('analista') == $analista->id) selected @endif value="{{$analista->id}}">{{$analista->name}}</option>
                                    @endforeach
                                </select>

                                @error('analista')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                @if($filtro !=  "concluidas")
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>
                        <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" form="form-criar-visita-denuncia">Agendar</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @can('isSecretario', \App\Models\User::class)
        <div class="modal fade" id="modal-atribuir" tabindex="-1" role="dialog" aria-labelledby="modal-imagens" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Atribuir denúncia a um analista</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="alerta-atribuida">
                            </div>
                        </div>
                        <form id="form-atribuir-analista-denuncia" method="POST" action="{{route('denuncias.atribuir.analista')}}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <input type="hidden" name="denuncia_id_analista" id="denuncia_id_analista" value="">
                                    <label for="analista">{{__('Selecione o analista')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="analista" id="analista-atribuido" class="form-control @error('analista') is-invalid @enderror" required>
                                        <option value="" selected disabled>-- {{__('Selecionar analista')}} --</option>
                                        @foreach ($analistas as $analista)
                                            <option @if(old('analista') == $analista->id) selected @endif value="{{$analista->id}}">{{$analista->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('analista')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    @if($filtro !=  "concluidas")
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault  submeterFormBotao" form="form-atribuir-analista-denuncia">Atribuir</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endcan
    @can('isSecretario', \App\Models\User::class)
        <div class="modal fade" id="modal-agendar-visita-editar" tabindex="-1" role="dialog" aria-labelledby="modal-imagens" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar visita</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-editar-visita-denuncia" method="POST" action="{{route('visitas.visita.edit')}}">
                            @csrf
                            <input type="hidden" name="filtro" id="filtro" value="{{$filtro}}">
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <label for="data">{{__('Data da visita')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input type="date" name="data" id="data-editar" class="form-control @error('data') is-invalid @enderror" required value="{{old('data')}}">

                                    @error('data')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 form-group">
                                    <input type="hidden" name="visita_id" id="visita_id" value="">
                                    <label for="analista">{{__('Selecione o analista da visita')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="analista" id="analista-visita-editar" class="form-control @error('analista') is-invalid @enderror" required>
                                        <option value="" selected disabled>-- {{__('Selecione o analista da visita')}} --</option>
                                        @foreach ($analistas as $analista)
                                            <option @if(old('analista') == $analista->id) selected @endif value="{{$analista->id}}">{{$analista->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('analista')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    @if($filtro !=  "concluidas")
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" form="form-editar-visita-denuncia">Editar</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endcan
    @if (old('denuncia_id') != null)
        @push ('scripts')
            <script>
                $(document).ready(function() {
                    $('#link-denuncias-aprovados').click();
                    $("#btn-criar-visita-{{old('denuncia_id')}}").click();
                });
            </script>
        @endpush
    @endif
    @can('isSecretario', \App\Models\User::class)
        @push ('scripts')
            <script>
                function adicionarId(id) {
                    document.getElementById('denuncia_id').value = id;
                    $("#alerta-agendar").html("");
                    $("#analista-visita").val("");
                    document.getElementById('data').value = "";
                    $.ajax({
                        url:"{{route('denuncias.info.ajax')}}",
                        type:"get",
                        data: {"denuncia_id": id},
                        dataType:'json',
                        success: function(denuncia) {
                            if(denuncia.analista_visita != null){
                                $("#analista-visita").val(denuncia.analista_visita.id).change();
                                document.getElementById('data').value = denuncia.marcada;
                                let alerta = `<div class="alert alert-success" role="alert">
                                                <p>Denúncia agendada.</p>
                                            </div>`;
                                $("#alerta-agendar").append(alerta);
                            }
                        }
                    });
                }

                function adicionarIdAtribuir(id) {
                    document.getElementById('denuncia_id_analista').value = id;
                    $("#alerta-atribuida").html("");
                    $("#analista-atribuido").val("");
                    $.ajax({
                        url:"{{route('denuncias.info.ajax')}}",
                        type:"get",
                        data: {"denuncia_id": id},
                        dataType:'json',
                        success: function(denuncia) {
                            if(denuncia.analista_atribuido != null){
                                $("#analista-atribuido").val(denuncia.analista_atribuido.id).change();
                                let alerta = `<div class="alert alert-success" role="alert">
                                                <p>Denúncia atribuída a um analista.</p>
                                            </div>`;
                                $("#alerta-atribuida").append(alerta);
                            }
                        }
                    });
                }

                function atualizarInputAprovar(resultado, id){
                    document.getElementById('inputAprovar-'+id).value = resultado;
                    var form = document.getElementById('form-avaliar-denuncia-'+id);
                    form.submit();
                }
            </script>
            <script>
                function adicionarIdEditar(id) {
                    document.getElementById('visita_id').value = id;
                    $("#analista-visita-editar").val("");
                    document.getElementById('data-editar').value = "";
                    $.ajax({
                        url:"{{route('visitas.info.ajax')}}",
                        type:"get",
                        data: {"visita_id": id},
                        dataType:'json',
                        success: function(visita) {
                            if(visita.analista_visita != null){
                                $("#analista-visita-editar").val(visita.analista_visita.id).change();
                                document.getElementById('data-editar').value = visita.marcada;
                            }
                        }
                    });
                }
            </script>
        @endpush
    @endcan
    @endsection
</x-app-layout>
