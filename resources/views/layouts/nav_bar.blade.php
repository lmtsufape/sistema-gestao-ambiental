<nav class="navbar navbar-expand-lg navbar-light bg-white" style="padding-top: 35px;">
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
                <li>
                    <a class="navbar-brand nav-link-logo" href="https://api.whatsapp.com/send?1=pt_BR&phone=558737627086" target="_blank">
                        <img class="img-logo" src="{{asset('img/whatsapp.svg')}}" alt="Logo whatsapp" style="height: 40px; width: 40px;">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light navbar-primaria">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-between">
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item align-self-center @if(request()->routeIs('welcome')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{route('welcome')}}">Início</a>
                    </li>
                    <li class="nav-item align-self-center @if(request()->routeIs('noticias.index')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{route('noticias.index')}}">Notícias</a>
                    </li>
                    <li class="nav-item align-self-center @if(request()->routeIs('legislacao')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{route('legislacao')}}">Legislação</a>
                    </li>
                    <li class="nav-item align-self-center @if(request()->routeIs('contato')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{route('contato')}}">Contato</a>
                    </li>
                    <li class="nav-item align-self-center @if(request()->routeIs('sobre')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{route('sobre')}}">Sobre</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item align-self-center @if(request()->routeIs('login')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{route('login')}}">Entrar</a>
                    </li>
                    <li class="nav-item align-self-center @if(request()->routeIs('register')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{route('register')}}">Cadastre-se</a>
                    </li>
                @else
                    <li class="nav-item @if(request()->routeIs('dashboard')) active @endif">
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
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
