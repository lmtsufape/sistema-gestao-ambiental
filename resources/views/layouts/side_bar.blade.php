<div class="wrapper">
    @guest
    @else
        <nav id="sidebar" class="active">
            <div class="sidebar-header" style="align-items: center">
                <a class="navbar-brand" id="logoSGA" style="display: none">
                    <img src="{{asset('img/icon-logo.svg')}}" alt="Sistema de gestão ambiental" style="height: 40px;">
                </a>
                <strong style="font-size: 18px">SGA</strong>
            </div>

            <ul class="list-unstyled components">
                <li class=" @if(request()->routeIs('welcome')) active @endif">
                    <a  href="{{route('welcome')}}">
                        <i class="fas fa-home"></i>
                        Início
                    </a>
                </li>
                @can('isSecretario', \App\Models\User::class)
                    <li class=" @if(request()->routeIs('requerimentos*') || request()->routeIs('boletos*') || request()->routeIs('documentos*') || request()->routeIs('valores*')) active @endif">
                        <a href="#licenciamentoSubmenu" data-toggle="collapse" @if(request()->routeIs('requerimentos*')) aria-expanded="true" class="dropdown-toggle" @else aria-expanded="false" class="dropdown-toggle collapsed" @endif>
                            <i class="fas fa-home"></i>
                            Licenciamento
                        </a>
                        <ul class="collapse list-unstyled @if(request()->routeIs('requerimentos*')  || request()->routeIs('boletos*') || request()->routeIs('documentos*') || request()->routeIs('valores*')) show @endif" id="licenciamentoSubmenu">
                            <li class=" @if(request()->routeIs('requerimentos*')) active @endif">
                                <a href="#requerimentosSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle" >
                                    Requerimentos
                                </a>
                                <ul class="collapse list-unstyled  @if(request()->routeIs('requerimentos*')) show @endif" id="requerimentosSubmenu" >
                                    <li class=" @if(request()->routeIs('requerimentos*')) active @endif">
                                        <a href="{{route('requerimentos.index', 'atuais')}}" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Atuais</a>
                                    </li>
                                    <li>
                                        <a href="{{route('requerimentos.index', 'finalizados')}}" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Finalizados</a>
                                    </li>
                                    <li>
                                        <a href="{{route('requerimentos.index', 'cancelados')}}" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Cancelados</a>
                                    </li>
                                </ul>
                            </li>
                            <li class=" @if(request()->routeIs('boletos*')) active @endif" >
                                <a href="#pagamentosSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                    Pagamentos
                                </a>
                                <ul class="collapse list-unstyled @if(request()->routeIs('boletos*')) show @endif" id="pagamentosSubmenu" >
                                    <li>
                                        <a href="{{route('boletos.index', 'pendentes')}}" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Pendentes</a>
                                    </li>
                                    <li>
                                        <a href="{{route('boletos.index', 'pagos')}}" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Pagos</a>
                                    </li>
                                    <li>
                                        <a href="{{route('boletos.index', 'vencidos')}}" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Vencidos</a>
                                    </li>
                                </ul>
                            </li>
                            <li class=" @if(request()->routeIs('documentos*')) active @endif">
                                <a href="{{route('documentos.index')}}" @if(request()->routeIs('documentos*')) style="background-color: #ffffff; color: #214b10;" @endif  >Definição de documentos</a>
                            </li>
                            <li class=" @if(request()->routeIs('valores*')) active @endif">
                                <a href="{{route('valores.index')}}" @if(request()->routeIs('valores*')) style="background-color: #ffffff; color: #214b10;" @endif>Valores de licenças</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if(request()->routeIs('denuncias*')) active @endif">
                        <a href="#denunciasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-home"></i>
                            Denúncias
                        </a>
                        <ul class="collapse list-unstyled @if(request()->routeIs('denuncias*')) show @endif" id="denunciasSubmenu">
                            <li>
                                <a href="{{route('denuncias.index', 'pendentes')}}" @if(request()->is('denuncias/pendentes/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Pendentes</a>
                            </li>
                            <li>
                                <a href="{{route('denuncias.index', 'deferidas')}}" @if(request()->is('denuncias/deferidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Deferidas</a>
                            </li>
                            <li>
                                <a href="{{route('denuncias.index', 'concluidas')}}" @if(request()->is('denuncias/concluidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Concluídas</a>
                            </li>
                            <li>
                                <a href="{{route('denuncias.index', 'indeferidas')}}" @if(request()->is('denuncias/indeferidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Indeferidas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if(request()->routeIs('mudas*') || request()->routeIs('especies*')) active @endif">
                        <a href="#mudasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-home"></i>
                            Mudas
                        </a>
                        <ul class="collapse list-unstyled @if(request()->routeIs('mudas*') || request()->routeIs('especies*')) show @endif" id="mudasSubmenu">
                            <li>
                                <a href="{{route('mudas.index', 'pendentes')}}" @if(request()->is('solicitacoes/mudas/pendentes/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Pendentes</a>
                            </li>
                            <li>
                                <a href="{{route('mudas.index', 'deferidas')}}" @if(request()->is('solicitacoes/mudas/deferidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Deferidas</a>
                            </li>
                            <li>
                                <a href="{{route('mudas.index', 'indeferidas')}}" @if(request()->is('solicitacoes/mudas/indeferidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Indeferidas</a>
                            </li>
                            <li>
                                <a href="{{route('especies.index')}}" @if(request()->routeIs('especies*')) style="background-color: #ffffff; color: #214b10;" @endif>Definição de espécies de mudas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if(request()->routeIs('podas*')) active @endif">
                        <a href="#podasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-home"></i>
                            Poda/<br>
                            <i class="fas fa-home"></i>
                            Supressão
                        </a>
                        <ul class="collapse list-unstyled @if(request()->routeIs('podas*')) show @endif" id="podasSubmenu">
                            <li>
                                <a href="{{route('podas.index', 'pendentes')}}" @if(request()->is('solicitacoes/podas/pendentes/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Pendentes</a>
                            </li>
                            <li>
                                <a href="{{route('podas.index', 'deferidas')}}" @if(request()->is('solicitacoes/podas/deferidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Deferidas</a>
                            </li>
                            <li>
                                <a href="{{route('podas.index', 'concluidas')}}" @if(request()->is('solicitacoes/podas/concluidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Concluídas</a>
                            </li>
                            <li>
                                <a href="{{route('podas.index', 'indeferidas')}}" @if(request()->is('solicitacoes/podas/indeferidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Indeferidas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if(request()->routeIs('visitas*')) active @endif">
                        <a href="{{route('visitas.index')}}">
                            <i class="fas fa-home"></i>
                            Programação
                        </a>
                    </li>
                    <li class="@if(request()->routeIs('setores*') || request()->routeIs('usuarios*') || request()->routeIs('cnaes*')) active @endif">
                        <a href="#configuracoesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-home"></i>
                            Configurações
                        </a>
                        <ul class="collapse list-unstyled @if(request()->routeIs('setores*') || request()->routeIs('usuarios*') || request()->routeIs('cnaes*')) show @endif" id="configuracoesSubmenu">
                            <li>
                                <a href="{{route('setores.index')}}" @if(request()->routeIs('setores*') || request()->routeIs('cnaes*')) style="background-color: #ffffff; color: #214b10;" @endif>Grupos (CNAEs)</a>
                            </li>
                            <li>
                                <a href="{{route('usuarios.index')}}" @if(request()->routeIs('usuarios*')) style="background-color: #ffffff; color: #214b10;" @endif>Usuários</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('isProcessoOrProtocolista', \App\Models\User::class)
                    <li class=" @if(request()->routeIs('requerimentos*') || request()->routeIs('requerimento*')) active @endif">
                        <a href="{{route('requerimentos.index', 'atuais')}}">
                            <i class="fas fa-home"></i>
                            Requerimentos
                        </a>
                    </li>
                    @can('isAnalistaProcesso', \App\Models\User::class)
                        <li class="@if(request()->routeIs('visitas*') || request()->routeIs('relatorios*') || request()->routeIs('empresas*')) active @endif">
                            <a href="{{route('visitas.index')}}">
                                <i class="fas fa-home"></i>
                                Programação
                            </a>
                        </li>
                    @endcan
                @endcan
                @can('isAnalistaPoda', \App\Models\User::class)
                    <li class="@if(request()->routeIs('mudas*') || request()->routeIs('especies*')) active @endif">
                        <a href="#mudasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-home"></i>
                            Mudas
                        </a>
                        <ul class="collapse list-unstyled @if(request()->routeIs('mudas*') || request()->routeIs('especies*')) show @endif" id="mudasSubmenu">
                            <li>
                                <a href="{{route('mudas.index', 'pendentes')}}" @if(request()->is('solicitacoes/mudas/pendentes/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Pendentes</a>
                            </li>
                            <li>
                                <a href="{{route('mudas.index', 'deferidas')}}" @if(request()->is('solicitacoes/mudas/deferidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Deferidas</a>
                            </li>
                            <li>
                                <a href="{{route('mudas.index', 'indeferidas')}}" @if(request()->is('solicitacoes/mudas/indeferidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Indeferidas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if(request()->routeIs('podas*')) active @endif">
                        <a href="#podasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <i class="fas fa-home"></i>
                            Poda/<br>
                            <i class="fas fa-home"></i>
                            Supressão
                        </a>
                        <ul class="collapse list-unstyled @if(request()->routeIs('podas*')) show @endif" id="podasSubmenu">
                            <li>
                                <a href="{{route('podas.index', 'deferidas')}}" @if(request()->is('solicitacoes/podas/deferidas/listar')) style="background-color: #ffffff; color: #214b10;" @endif>Atribuídas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="@if(request()->routeIs('visitas*') || request()->routeIs('relatorios*') || request()->routeIs('empresas*')) active @endif">
                        <a href="{{route('visitas.index')}}">
                            <i class="fas fa-home"></i>
                            Programação
                        </a>
                    </li>
                @endcan
                @can('isRequerente', \App\Models\User::class)
                    <li class=" @if(request()->routeIs('requerimentos*') || request()->routeIs('requerimento*')) active @endif">
                        <a href="{{route('requerimentos.index', 'atuais')}}">
                            <i class="fas fa-home"></i>
                            Requerimentos
                        </a>
                    </li>
                    <li class="@if(request()->routeIs('empresas*') || request()->routeIs('info.porte')) active @endif">
                        <a href="{{route('empresas.index')}}">
                            <i class="fas fa-home"></i>
                            Empresas/<br>
                            <i class="fas fa-home"></i>
                            Serviços
                        </a>
                    </li>
                    <li class="@if(request()->routeIs('mudas.*')) active @endif">
                        <a href="{{route('mudas.requerente.index')}}">
                            <i class="fas fa-home"></i>
                            Mudas
                        </a>
                    </li>
                    <li class="@if(request()->routeIs('podas.*')) active @endif">
                        <a href="{{route('podas.requerente.index')}}">
                            <i class="fas fa-home"></i>
                            Poda/<br>
                            <i class="fas fa-home"></i>
                            Supressão
                        </a>
                    </li>
                @endcan
            </ul>

            <ul class="list-unstyled CTAs">
            </ul>
        </nav>
    @endguest

    <!-- Page Content  -->
    <div id="content">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                @guest
                    <a class="navbar-brand" href="{{route('welcome')}}">
                        <img src="{{asset('img/icon-logo.png')}}" alt="Sistema de gestão ambiental" style="height: 40px;">
                    </a>
                @else
                    <button type="button" id="sidebarCollapse" onclick="toggleSideBar()" class="navbar-brand">
                        <img src="{{asset('img/icon-logo.png')}}" alt="Sistema de gestão ambiental" style="height: 40px;">
                    </button>
                    <button type="button" id="sidebarCollapseClose" onclick="toggleSideBar()" class="navbar-brand" style="display: none; margin-left: 10px;">
                        <i class="close">&times;</i>
                    </button>
                @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
        
                <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item @if(request()->routeIs('welcome')) active @endif">
                            <a class="nav-link" href="{{route('welcome')}}">Início</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('noticias*')) active @endif">
                            <a class="nav-link" href="{{route('noticias.index')}}">Notícias</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('legislacao')) active @endif">
                            <a class="nav-link" href="{{route('legislacao')}}">Legislação</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('contato')) active @endif">
                            <a class="nav-link" href="{{route('contato')}}">Contato</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('sobre')) active @endif">
                            <a class="nav-link" href="{{route('sobre')}}">Sobre</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown_outros" role="button" data-toggle="dropdown" aria-expanded="false">
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
        <div>
            @yield('content')
        </div>
    </div>
</div>

<script>
    function toggleSideBar(){
        if($('#logoSGA').is(":hidden")){
            $('#logoSGA').show();
            $('#sidebarCollapse').hide();
            $('#sidebarCollapseClose').show();
        }else{
            $('#logoSGA').hide();
            $('#sidebarCollapse').show();
            $('#sidebarCollapseClose').hide();
        }
        $('#sidebar').toggleClass('active');
    }
</script>
