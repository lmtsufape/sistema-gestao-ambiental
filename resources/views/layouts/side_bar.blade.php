<div class="wrapper h-100">
    <!-- Page Content  -->
    <div id="content" style="min-height: 100%; grid-template-rows: auto auto 1fr; display: grid;">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding-top: 35px;">
            <div class="container" style="">
                <a class="navbar-brand nav-link-logo" href="{{route('welcome')}}">
                    <img class="img-logo" src="{{asset('img/logo.svg')}}" alt="Logo SGA" style="height: 100px; width: 250px;">
                </a>
                <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav ml-auto">
                        <li>
                            <a class="navbar-brand nav-link-logo" href="https://www.instagram.com/prefgaranhuns/" target="_blank">
                                <img class="img-logo" src="{{asset('img/ig.svg')}}" alt="Logo ig" style="height: 40px; width: 40px;">
                            </a>
                        </li>
                        <li>
                            <a class="navbar-brand nav-link-logo" href="https://www.facebook.com/PrefeituraGaranhuns/" target="_blank">
                                <img class="img-logo" src="{{asset('img/fb.svg')}}" alt="Logo fb" style="height: 40px; width: 40px;">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light navbar-primaria">
            <div class="container">
                @guest
                    <a class="navbar-brand" href="{{route('welcome')}}">
                        <img src="{{asset('img/logo.svg')}}" alt="Sistema de gestão ambiental" style="height: 40px;">
                    </a>
                @else
                    <button type="button" id="sidebarCollapse" onclick="toggleSideBar()" class="navbar-brand">
                        <img src="{{asset('img/sidebar-icon.svg')}}" alt="Sistema de gestão ambiental" style="height: 35px;">
                    </button>
                @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-between">
                    <ul class="navbar-nav">
                        <li class="nav-item @if(request()->routeIs('welcome')) active @endif">
                            <a class="nav-link text-uppercase font-weight-bold" href="{{route('welcome')}}">Início</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('noticias*')) active @endif">
                            <a class="nav-link text-uppercase font-weight-bold" href="{{route('noticias.index')}}">Notícias</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('legislacao')) active @endif">
                            <a class="nav-link text-uppercase font-weight-bold" href="{{route('legislacao')}}">Legislação</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('contato')) active @endif">
                            <a class="nav-link text-uppercase font-weight-bold" href="{{route('contato')}}">Contato</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('sobre')) active @endif">
                            <a class="nav-link text-uppercase font-weight-bold" href="{{route('sobre')}}">Sobre</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link text-uppercase font-weight-bold dropdown-toggle" href="#" id="navbarDropdown_outros" role="button" data-toggle="dropdown" aria-expanded="false">
                                {{Auth::user()->name}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown_outros">
                                <a class="dropdown-item" href="{{route('infoLogin')}}">{{ __('Informações de Login') }}</a>
                                <a class="dropdown-item" href="{{route('perfil')}}">{{ __('Perfil') }}</a>
                                <!-- Authentication -->
                                <form method="POST" action="{{route('logout')}}">
                                    @csrf
                                    <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                                        this.closest('form').submit();">{{__('Sair')}}</a>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="conteudo">
            <div class="container-fluid" style="padding-left: 15px;">
                <div class="row">
                    <div class="col-md-2" style="padding-top: 3rem; padding-right: 0px; padding-left: 0px; clip-path: inset(0px -12px 0px 0px); max-width: fit-content; padding-left: 2rem;">
                        <ul id="sidebar" class="list-unstyled">
                            @can('isSecretario', \App\Models\User::class)
                                <li class="mb-2 @if(request()->routeIs('requerimentos*') || request()->routeIs('boletos*') || request()->routeIs('documentos*') || request()->routeIs('valores*')) active @endif">
                                    <button href="#licenciamentoSubmenu" data-toggle="collapse" aria-expanded="false" class="btn btn-toggle">
                                        <i class="fas fa-home"></i>
                                        Licenciamento
                                    </button>
                                    <ul class="btn-toggle-nav collapse list-unstyled fw-normal pb-1 small @if(request()->routeIs('requerimentos*')  || request()->routeIs('boletos*') || request()->routeIs('documentos*') || request()->routeIs('valores*')) show @endif" id="licenciamentoSubmenu">
                                        <li class=" @if(request()->routeIs('requerimentos*')) active @endif">
                                            <a href="{{route('requerimentos.index', 'atuais')}}">Requerimentos</a>
                                        </li>
                                        <li class=" @if(request()->routeIs('boletos*')) active @endif">
                                            <a href="{{route('boletos.index', 'pendentes')}}" >Pagamentos</a>
                                        </li>
                                        <li class=" @if(request()->routeIs('documentos*')) active @endif">
                                            <a href="{{route('documentos.index')}}" @if(request()->routeIs('documentos*')) @endif  >Definição de documentos</a>
                                        </li>
                                        <li class=" @if(request()->routeIs('valores*')) active @endif">
                                            <a href="{{route('valores.index')}}" @if(request()->routeIs('valores*')) @endif>Valores de licenças</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="mb-2 item-align @if(request()->routeIs('denuncias*')) active @endif">
                                    <a href="{{route('denuncias.index', 'pendentes')}}">
                                        <i class="fas fa-home"></i>
                                        Denúncias
                                    </a>
                                </li>
                                <li class="mb-2 @if(request()->routeIs('mudas*') || request()->routeIs('especies*')) active @endif">
                                    <button href="#mudasSubmenu" data-toggle="collapse" aria-expanded="false" class="btn btn-toggle">
                                        <i class="fas fa-home"></i>
                                        Mudas
                                    </button>
                                    <ul class="btn-toggle-nav collapse list-unstyled fw-normal pb-1 small @if(request()->routeIs('mudas*') || request()->routeIs('especies*')) show @endif" id="mudasSubmenu">
                                        <li class="@if(request()->is('solicitacoes/mudas/pendentes/listar')) active @endif">
                                            <a href="{{route('mudas.index', 'pendentes')}}" >Solicitações</a>
                                        </li>
                                        <li class="@if(request()->routeIs('especies*')) active @endif">
                                            <a href="{{route('especies.index')}}">Definição de espécies de mudas</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="mb-2 item-align @if(request()->routeIs('podas*')) active @endif">
                                    <a href="{{route('podas.index', 'pendentes')}}">
                                        <i class="fas fa-home"></i>
                                        Poda/Supressão
                                    </a>
                                </li>
                                <li class="mb-2 item-align @if(request()->routeIs('empresas*')) active @endif">
                                    <a href="{{route('empresas.listar')}}">
                                        <i class="fas fa-home"></i>
                                        Empresas/<br>
                                        <i class="fas fa-home"></i>
                                        Serviços
                                    </a>
                                </li>
                                <li class="mb-2 item-align @if(request()->routeIs('visitas*')) active @endif">
                                    <a href="{{route('visitas.index')}}">
                                        <i class="fas fa-home"></i>
                                        Programação
                                    </a>
                                </li>
                                <li class="mb-2 @if(request()->routeIs('setores*') || request()->routeIs('usuarios*') || request()->routeIs('cnaes*')) active @endif">
                                    <button href="#configuracoesSubmenu" data-toggle="collapse" aria-expanded="false" class="btn btn-toggle">
                                        <i class="fas fa-home"></i>
                                        Configurações
                                    </button>
                                    <ul class="btn-toggle-nav collapse list-unstyled fw-normal pb-1 small @if(request()->routeIs('setores*') || request()->routeIs('usuarios*') || request()->routeIs('cnaes*')) show @endif" id="configuracoesSubmenu">
                                        <li class="@if(request()->routeIs('setores*') || request()->routeIs('cnaes*')) active @endif">
                                            <a href="{{route('setores.index')}}">Grupos (CNAEs)</a>
                                        </li>
                                        <li class="@if(request()->routeIs('usuarios*')) active @endif">
                                            <a href="{{route('usuarios.index')}}">Usuários</a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('isProcessoOrProtocolista', \App\Models\User::class)
                                <li class="mb-2 item-align @if(request()->routeIs('requerimentos*') || request()->routeIs('requerimento*')) active @endif">
                                    <a href="{{route('requerimentos.index', 'atuais')}}">
                                        <i class="fas fa-home"></i>
                                        Requerimentos
                                    </a>
                                </li>
                                <li class="mb-2 item-align @if(request()->routeIs('empresas*')) active @endif">
                                    <a href="{{route('empresas.listar')}}">
                                        <i class="fas fa-home"></i>
                                        Empresas/<br>
                                        <i class="fas fa-home"></i>
                                        Serviços
                                    </a>
                                </li>
                                @can('isAnalistaProcesso', \App\Models\User::class)
                                    <li class="mb-2 item-align @if(request()->routeIs('visitas*') || request()->routeIs('relatorios*')) active @endif">
                                        <a href="{{route('visitas.index')}}">
                                            <i class="fas fa-home"></i>
                                            Programação
                                        </a>
                                    </li>
                                @endcan
                            @endcan
                            @can('isAnalistaPoda', \App\Models\User::class)
                                <li class="mb-2 item-align @if(request()->routeIs('mudas*') || request()->routeIs('especies*')) active @endif">
                                    <a href="{{route('mudas.index', 'pendentes')}}" >
                                        <i class="fas fa-home"></i>
                                        Mudas
                                    </a>
                                </li>
                                <li class="mb-2 item-align @if(request()->routeIs('podas*')) active @endif">
                                    <a href="{{route('podas.index', 'deferidas')}}" @if(request()->is('solicitacoes/podas/deferidas/listar'))@endif>
                                        <i class="fas fa-home"></i>
                                        Poda/Supressão
                                    </a>
                                </li>
                                <li class="mb-2 item-align @if(request()->routeIs('empresas*')) active @endif">
                                    <a href="{{route('empresas.listar')}}">
                                        <i class="fas fa-home"></i>
                                        Empresas/<br>
                                        <i class="fas fa-home"></i>
                                        Serviços
                                    </a>
                                </li>
                                <li class="mb-2 item-align @if(request()->routeIs('visitas*') || request()->routeIs('relatorios*')) active @endif">
                                    <a href="{{route('visitas.index')}}">
                                        <i class="fas fa-home"></i>
                                        Programação
                                    </a>
                                </li>
                            @endcan
                        @can('isAnalistaPoda', \App\Models\User::class)
                            <li class="mb-2 item-align @if(request()->routeIs('mudas*') || request()->routeIs('especies*')) active @endif">
                                <a href="{{route('mudas.index', 'pendentes')}}" >
                                    <i class="fas fa-home"></i>
                                    Mudas
                                </a>
                            </li>
                            <li class="mb-2 item-align @if(request()->routeIs('podas*')) active @endif">
                                <a href="{{route('podas.index', 'deferidas')}}" @if(request()->is('solicitacoes/podas/deferidas/listar'))@endif>
                                    <i class="fas fa-home"></i>
                                    Poda/Supressão
                                </a>
                            </li>
                            <li class="mb-2 item-align @if(request()->routeIs('visitas*') || request()->routeIs('relatorios*') || request()->routeIs('empresas*')) active @endif">
                                <a href="{{route('visitas.index')}}">
                                    <i class="fas fa-home"></i>
                                    Programação
                                </a>
                            </li>
                        @endcan
                        @can('isRequerente', \App\Models\User::class)
                            <li class="mb-2 item-align @if(request()->routeIs('requerimentos*') || request()->routeIs('requerimento*')) active @endif">
                                <a href="{{route('requerimentos.index', 'atuais')}}">
                                    <i class="fas fa-home"></i>
                                    Requerimentos
                                </a>
                            </li>
                            <li class="mb-2 item-align @if(request()->routeIs('empresas*') || request()->routeIs('info.porte')) active @endif">
                                <a href="{{route('empresas.index')}}">
                                    <i class="fas fa-home"></i>
                                    Empresas/<br>
                                    <i class="fas fa-home"></i>
                                    Serviços
                                </a>
                            </li>
                            <li class="mb-2 item-align @if(request()->routeIs('mudas.*')) active @endif">
                                <a href="{{route('mudas.requerente.index')}}">
                                    <i class="fas fa-home"></i>
                                    Mudas
                                </a>
                            </li>
                            <li class="mb-2 item-align @if(request()->routeIs('podas.*')) active @endif">
                                <a href="{{route('podas.requerente.index')}}">
                                    <i class="fas fa-home"></i>
                                    Poda/<br>
                                    <i class="fas fa-home"></i>
                                    Supressão
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
                <div id="pagina-carregada" class="col-md-10">
                    @can('isRequerente', \App\Models\User::class)
                        @if(Auth::user()->requerimentosDocumentosAnexadosNotificacao() != null)
                            <div id="card-notificacao" aria-live="polite" aria-atomic="true" style="position: relative; z-index: 1;">
                                <div class="card" style="position: absolute; right: 0; top: 0; width: 300px;">
                                    <div class="card-header" style="background-color: #F26565; color: white;">
                                        <strong class="mr-auto" style="font-size: 26px;">Alerta!</strong>
                                        {{--<small>11 mins ago</small>--}}
                                        <button type="button" class="ml-2 mb-1 close" data-dismiss="card" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                Você necessita concluir o envio dos documentos do requerimento de {{Auth::user()->requerimentosDocumentosAnexadosNotificacao()->tipoString()}} da(o) {{Auth::user()->requerimentosDocumentosAnexadosNotificacao()->empresa->nome}}!
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{route('requerimento.documentacao', Auth::user()->requerimentosDocumentosAnexadosNotificacao()->id)}}">Clique aqui</a> para ir à página
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endcan
                    @yield('content')
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function toggleSideBar(){
        if($('#logoSGA').is(":hidden")){
            $('#logoSGA').show();
            $('#sidebarCollapse').hide();
            $('#sidebarCollapseClose').show();
            $('#logoImage').hide();
        }else{
            $('#logoSGA').hide();
            $('#sidebarCollapse').show();
            $('#sidebarCollapseClose').hide();
            if($('#logoImage').is(":hidden")){
                $('#logoImage').show();
            }
        }
        $('#sidebar').toggleClass('active');
    }
    $('#card-notificacao .close').click(function(){
        $('#card-notificacao').slideUp();
    })
</script>
