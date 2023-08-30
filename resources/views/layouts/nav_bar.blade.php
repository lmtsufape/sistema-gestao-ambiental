<nav class="navbar navbar-expand-lg navbar-light bg-white" style="padding-top: 35px;">
    <div class="container" style="">
        <a class="navbar-brand nav-link-logo" href="{{ route('welcome') }}">
            <img class="img-logo" src="{{ asset('img/logo.svg') }}" alt="Logo SGA" style="height: 100px; width: 250px;">
        </a>
        <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav ml-auto">
                <li>
                    <a class="navbar-brand nav-link-logo" href="https://www.instagram.com/prefgaranhuns/"
                        target="_blank">
                        <img class="img-logo" src="{{ asset('img/ig.svg') }}" alt="Logo ig"
                            style="height: 40px; width: 40px;">
                    </a>
                </li>
                <li>
                    <a class="navbar-brand nav-link-logo" href="https://www.facebook.com/PrefeituraGaranhuns/"
                        target="_blank">
                        <img class="img-logo" src="{{ asset('img/fb.svg') }}" alt="Logo fb"
                            style="height: 40px; width: 40px;">
                    </a>
                </li>
                <li>
                    <a class="navbar-brand nav-link-logo"
                        href="https://api.whatsapp.com/send?1=pt_BR&phone=558737627086" target="_blank">
                        <img class="img-logo" src="{{ asset('img/whatsapp.svg') }}" alt="Logo whatsapp"
                            style="height: 40px; width: 40px;">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light navbar-primaria">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbarSupportedContent" class="collapse navbar-collapse justify-content-between">
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item align-self-center @if (request()->routeIs('welcome')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{ route('welcome') }}">Início</a>
                    </li>
                    <li class="nav-item align-self-center @if (request()->routeIs('noticias.index')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold"
                            href="{{ route('noticias.index') }}">Notícias</a>
                    </li>
                    <li class="nav-item align-self-center @if (request()->routeIs('legislacao')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{ route('legislacao') }}">Legislação</a>
                    </li>
                    <li class="nav-item align-self-center @if (request()->routeIs('contato')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{ route('contato') }}">Contato</a>
                    </li>
                    <li class="nav-item align-self-center @if (request()->routeIs('sobre')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{ route('sobre') }}">Sobre</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item align-self-center @if (request()->routeIs('login')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{ route('login') }}">Entrar</a>
                    </li>
                    <li class="nav-item align-self-center @if (request()->routeIs('register')) active @endif">
                        <a class="nav-link text-uppercase font-weight-bold" href="{{ route('register') }}">Cadastre-se</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
