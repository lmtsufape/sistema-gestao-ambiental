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
                <li class=" @if(request()->routeIs('requerimentos*') || request()->routeIs('boletos*')))   active @endif">
                    <a href="#licenciamentoSubmenu" data-toggle="collapse" @if(request()->routeIs('requerimentos*')) aria-expanded="true" class="dropdown-toggle" @else aria-expanded="false" class="dropdown-toggle collapsed" @endif>
                        <i class="fas fa-home"></i>
                        Licenciamento
                    </a>
                    <ul class="collapse list-unstyled @if(request()->routeIs('requerimentos*')  || request()->routeIs('boletos*'))) show @endif" id="licenciamentoSubmenu">
                        <li class=" @if(request()->routeIs('requerimentos*')) active @endif">
                            <a href="#requerimentosSubmenu" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle" >
                                Requerimentos
                            </a>
                            <ul class="collapse list-unstyled  @if(request()->routeIs('requerimentos*')) show @endif" id="requerimentosSubmenu" >
                                <li class=" @if(request()->routeIs('requerimentos*')) active @endif">
                                    <a href="{{route('requerimentos.index')}}" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Atuais</a>
                                </li>
                                <li>
                                    <a href="#" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Finalizados</a>
                                </li>
                                <li>
                                    <a href="#" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Cancelados</a>
                                </li>
                            </ul>
                        </li>
                        <li class=" @if(request()->routeIs('boletos*')) active @endif" >
                            <a href="#pagamentosSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                                Pagamentos
                            </a>
                            <ul class="collapse list-unstyled @if(request()->routeIs('boletos*')) show @endif" id="pagamentosSubmenu" >
                                <li>
                                    <a href="{{route('boletos.index')}}" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Pendentes</a>
                                </li>
                                <li>
                                    <a href="#" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Pagos</a>
                                </li>
                                <li>
                                    <a href="#" style="background-color: #133306;" onMouseOver="this.style.color='rgb(170, 245, 154)'" onMouseOut="this.style.color='rgb(255, 255, 255)'">Vencidos</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Definição de documentos</a>
                        </li>
                        <li>
                            <a href="#">Valores de licenças</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#denunciasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-home"></i>
                        Denúncias
                    </a>
                    <ul class="collapse list-unstyled" id="denunciasSubmenu">
                        <li>
                            <a href="#">Pendentes</a>
                        </li>
                        <li>
                            <a href="#">Aprovadas</a>
                        </li>
                        <li>
                            <a href="#">Arquivadas</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#mudasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-home"></i>
                        Mudas
                    </a>
                    <ul class="collapse list-unstyled" id="mudasSubmenu">
                        <li>
                            <a href="#">Pendentes</a>
                        </li>
                        <li>
                            <a href="#">Deferidas</a>
                        </li>
                        <li>
                            <a href="#">Indeferidas</a>
                        </li>
                        <li>
                            <a href="#">Definição de espécies de mudas</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#podasSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-home"></i>
                        Podas
                    </a>
                    <ul class="collapse list-unstyled" id="podasSubmenu">
                        <li>
                            <a href="#">Pendentes</a>
                        </li>
                        <li>
                            <a href="#">Deferidas</a>
                        </li>
                        <li>
                            <a href="#">Indeferidas</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#configuracoesSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-home"></i>
                        Configurações
                    </a>
                    <ul class="collapse list-unstyled" id="configuracoesSubmenu">
                        <li>
                            <a href="#">CNAEs</a>
                        </li>
                        <li>
                            <a href="#">Usuários</a>
                        </li>
                    </ul>
                </li>
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
                        <li class="nav-item @if(request()->routeIs('noticias.index')) active @endif">
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
