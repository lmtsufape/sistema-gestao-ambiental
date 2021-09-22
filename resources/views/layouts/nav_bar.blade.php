<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{route('welcome')}}">
            <img src="{{asset('img/icon-logo.png')}}" alt="Sistema de gestão ambiental" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item @if(request()->routeIs('welcome')) active @endif">
                    <a class="nav-link" href="{{route('welcome')}}">Inicio</a> 
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Legislação</a>
                </li>
                <li class="nav-item @if(request()->routeIs('contato')) active @endif">
                    <a class="nav-link" href="{{route('contato')}}">Contato</a>
                </li>
                @guest
                    <li class="nav-item @if(request()->routeIs('login')) active @endif">
                        <a class="nav-link login" href="{{route('login')}}">Entrar</a>
                    </li>
                @else
                    <li class="nav-item @if(request()->routeIs('dashboard')) active @endif">
                        <a class="nav-link login" href="{{route('dashboard')}}">Dashboard</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>