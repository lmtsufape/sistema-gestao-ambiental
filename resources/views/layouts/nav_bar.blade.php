<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{route('welcome')}}">
            <img src="{{asset('img/icon-logo.png')}}" alt="Sistema de gestão ambiental" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav ml-auto">
                @guest
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
                    <li class="nav-item @if(request()->routeIs('login')) active @endif">
                        <a class="nav-link" href="{{route('login')}}">Entrar</a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('register')) active @endif">
                        <a class="nav-link" href="{{route('register')}}">Cadastre-se</a>
                    </li>
                @else
                    {{-- <li class="nav-item @if(request()->routeIs('dashboard')) active @endif">
                        <a class="nav-link" href="{{route('dashboard')}}">{{ __('Dashboard') }}</a>
                    </li>
                    @can('isRequerente', \App\Models\User::class)
                        <li class="nav-item @if(request()->routeIs('mudas.*')) active @endif">
                            <a class="nav-link" href="{{route('mudas.requerente.index')}}">{{ __('Solicitações de mudas') }}</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('podas.*')) active @endif">
                            <a class="nav-link" href="{{route('podas.requerente.index')}}">{{ __('Solicitações de podas') }}</a>
                        </li>
                    @endcan
                    @can('isRequerente', \App\Models\User::class)
                        <li class="nav-item @if(request()->routeIs('requerimentos.*')) active @endif">
                            <a class="nav-link" href="{{route('requerimentos.index')}}">{{ __('Requerimento') }}</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('empresas.*')) active @endif">
                            <a class="nav-link" href="{{route('empresas.index')}}">{{ __('Empresas/Serviços') }}</a>
                        </li>
                    @endcan
                    @can('isProcessoOrProtocolista', \App\Models\User::class)
                        <li class="nav-item @if(request()->routeIs('visitas.*')) active @endif">
                            <a class="nav-link" href="{{route('visitas.index')}}">{{ __('Programação') }}</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('denuncias.*')) active @endif">
                            <a class="nav-link" href="{{route('denuncias.index')}}">{{ __('Denúncias') }}</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('requerimentos.*')) active @endif">
                            <a class="nav-link" href="{{route('requerimentos.index')}}">{{ __('Requerimentos') }}</a>
                        </li>
                    @endcan
                    @can('isAnalistaPoda', \App\Models\User::class)
                        <li class="nav-item @if(request()->routeIs('mudas.*')) active @endif">
                            <a class="nav-link" href="{{route('mudas.index')}}">{{ __('Mudas') }}</a>
                        </li>
                        </li>
                        <li class="nav-item @if(request()->routeIs('podas.*')) active @endif">
                            <a class="nav-link" href="{{route('podas.index')}}">{{ __('Podas') }}</a>
                        </li>
                    @endcan
                    @can('isSecretario', \App\Models\User::class)
                        <li class="nav-item @if(request()->routeIs('visitas.*')) active @endif">
                            <a class="nav-link" href="{{route('visitas.index')}}">{{ __('Programação') }}</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('denuncias.*')) active @endif">
                            <a class="nav-link" href="{{route('denuncias.index')}}">{{ __('Denúncias') }}</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('mudas.*')) active @endif">
                            <a class="nav-link" href="{{route('mudas.index')}}">{{ __('Mudas') }}</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('podas.*')) active @endif">
                            <a class="nav-link" href="{{route('podas.index')}}">{{ __('Podas') }}</a>
                        </li>
                        <li class="nav-item @if(request()->routeIs('requerimentos.*')) active @endif">
                            <a class="nav-link" href="{{route('requerimentos.index')}}">{{ __('Requerimentos') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown_outros" role="button" data-toggle="dropdown" aria-expanded="false">
                              Outros
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown_outros">
                                <a class="dropdown-item" href="{{route('boletos.index')}}">{{__('Pagamentos')}}</a>
                                <a class="dropdown-item" href="{{route('documentos.index')}}">{{__('Documentos')}}</a>
                                <a class="dropdown-item" href="{{route('especies.index')}}">{{__('Espécies de muda')}}</a>
                                <a class="dropdown-item" href="{{route('setores.index')}}">{{__('Grupos')}}</a>
                                <a class="dropdown-item" href="{{route('noticias.index')}}">{{__('Notícias')}}</a>
                                <a class="dropdown-item" href="{{route('usuarios.index')}}">{{__('Usuários')}}</a>
                                <a class="dropdown-item" href="{{route('valores.index')}}">{{__('Valores')}}</a>
                            </div>
                        </li>
                    @endcan
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
                    </li> --}}
                @endguest
            </ul>
        </div>
    </div>
</nav>
