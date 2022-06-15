@guest
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name', 'Sistema de Gestão Ambiental')}}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;600;700&display=swap">

    <!-- Styles -->
    {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="icon" type="imagem/png" href="{{asset('img/icon-page.png')}}" />

    @livewireStyles

    <!-- Scripts -->
    <script src="{{asset('js/app.js')}}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.4.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" defer></script>
    <script type='text/javascript' src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    @component('layouts.nav_bar')@endcomponent
    <div class="container conteudo" style="margin-top: 40px;">
        <div class="row">
            <div class="col-md-12" style="font-weight: bold; font-size: 16px; color: #00883D">
                PRINCIPAIS SERVIÇOS
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        EMISSÃO DE LICENÇAS
                                    </p>
                                </div>
                                <div class="col-md-4" style="text-align: right;">
                                    <img src="{{asset('img/emissao.svg')}}" width="35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        RENOVAÇÃO DE LICENÇA
                                    </p>
                                </div>
                                <div class="col-md-3" style="text-align: right;">
                                    <img src="{{asset('img/renovacao.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{route('denuncias.create')}}" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        REGISTRO DE <br> DENÚNCIAS
                                    </p>
                                </div>
                                <div class="col-md-3" style="text-align: right;">
                                    <img src="{{asset('img/denuncias.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        CONSULTAS DE LICENÇAS AMBIENTAIS
                                    </p>
                                </div>
                                <div class="col-md-3" style="text-align: right;">
                                    <img src="{{asset('img/consulta.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        ACOMPANHAMENTO DE SOLICITAÇÕES
                                    </p>
                                </div>
                                <div class="col-md-4" style="text-align: right;">
                                    <img src="{{asset('img/acompanhar.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-10">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        SOLICITAÇÃO DE PODA OU SUPRESSÃO DE ÁRVORES
                                    </p>
                                </div>
                                <div class="col-md-2" style="text-align: right;">
                                    <img src="{{asset('img/poda.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <br>
        @if ($noticias->count() > 0)  
            <div class="row">
                <div class="col-md-12" style="font-weight: bold; font-size: 16px; color: #00883D;">
                    NOTÍCIAS EM DESTAQUE
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between">
                        <div class="col-md-8" style="padding-left: 0px; padding-right: 0px">
                            <div id="carouselNoticiasCaptions" class="carousel slide" data-ride="carousel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <img id="icon-prev-carousel" class="carousel-control-prev alinhar-verticalmente" href="#carouselNoticiasCaptions" role="button" data-slide="prev" src="{{asset('img/back-green-com.svg')}}" alt="" style="width: 50px">
                                        <ol class="carousel-indicators">
                                            @foreach ($noticias as $i => $noticia)
                                                @if ($i == 0)
                                                    <li data-target="#carouselNoticiasCaptions" data-slide-to="{{$i}}" class="active"></li>
                                                @else
                                                    <li data-target="#carouselNoticiasCaptions" data-slide-to="{{$i}}"></li>
                                                @endif
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach ($noticias as $i => $noticia)
                                                <div class="carousel-item @if($i == 0)active @endif">
                                                    <a class="link-carousel" href="{{$noticia->link}}" target="_blank">
                                                        <img class="img-carousel" src="{{asset('storage/'.$noticia->imagem_principal)}}" class="d-block w-100" alt="Imagem da notícia {{$noticia->titulo}}" height="400px">
                                                    </a>
                                                    <div class="carousel-caption" style="right: 0%; left: 0%">
                                                        <div style="
                                                        bottom: 0;
                                                        background: rgb(0, 0, 0);
                                                        background: rgba(0, 0, 0, 0.8);
                                                        color: #f1f1f1;
                                                        padding: 20px;
                                                        padding-bottom: 0;
                                                        padding-top: 5;">
                                                            <a class="link-carousel" href="{{$noticia->link}}" target="_blank"><h5>{{$noticia->titulo}}</h5></a>
                                                            <p style="font-size: 12px; color: rgb(202, 202, 202);">
                                                                {!! mb_strimwidth(strip_tags($noticia->texto), 0, 200, "...") !!}
                                                            </p> 
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <img id="icon-next-carousel" class="carousel-control-next alinhar-verticalmente" href="#carouselNoticiasCaptions" role="button" data-slide="next" src="{{asset('img/next-green-com.svg')}}" alt="" style="width: 50px">
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <div class="col-md-4" style="background-color: rgb(61, 61, 61)" style="padding-left: 0px; padding-right: 0px">
                            @foreach ($noticias as $i => $noticia)
                                @if($i < 3)
                                    <a href="{{$noticia->link}}" style="text-decoration:none" onmouseover="style='text-decoration:underline'" onmouseout="style='text-decoration:none'">
                                        <br>
                                        <div class="form-row col-md-12" style="font-size: 12px; color: whitesmoke">
                                            {{date('d/m/Y', strtotime($noticia->created_at))}}
                                        </div>
                                        <div class="form-row col-md-12" style="font-weight: bold; font-size: 16px; color: whitesmoke">
                                            {{$noticia->titulo}}
                                            <br>
                                            <span style="font-weight: bold; font-size: 14px;">
                                                {!! mb_strimwidth(strip_tags($noticia->texto), 0, 100, "...") !!}
                                            </span> 
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: right">
                    <a href="{{route('noticias.index')}}" style="font-weight: bold; font-style: italic; text-decoration: underline; color: #00883D">
                        Ver todas as notícias
                    </a>
                </div>
            </div>
        @endif
    </div>
    @component('layouts.footer')@endcomponent
    <script>
        function mostrarContato(tipo, texto, img){
            if(tipo == "mostrar1"){
                if(document.getElementById("mostrar1").style.display == "block"){
                    document.getElementById("mostrar1").style.display = "none";
                    document.getElementById("mostrar2").style.display = "block";
                    document.getElementById("texto1").innerHTML="Mostrar";
                    document.getElementById("texto2").innerHTML="Fechar";
                    document.getElementById("img1").style.display = "none";
                    document.getElementById("img2").style.display = "block";
                }else if(document.getElementById("mostrar1").style.display == "none"){
                    document.getElementById("mostrar1").style.display = "block";
                    document.getElementById("mostrar2").style.display = "none";
                    document.getElementById("texto1").innerHTML="Fechar";
                    document.getElementById("texto2").innerHTML="Mostrar";
                    document.getElementById("img1").style.display = "block";
                    document.getElementById("img2").style.display = "none";
                }
            }else if(tipo == "mostrar2"){
                if(document.getElementById("mostrar2").style.display == "block"){
                    document.getElementById("mostrar2").style.display = "none";
                    document.getElementById("mostrar1").style.display = "block";
                    document.getElementById("texto2").innerHTML="Mostrar";
                    document.getElementById("texto1").innerHTML="Fechar";
                    document.getElementById("img2").style.display = "none";
                    document.getElementById("img1").style.display = "block";
                }else if(document.getElementById("mostrar2").style.display == "none"){
                    document.getElementById("mostrar2").style.display = "block";
                    document.getElementById("mostrar1").style.display = "none";
                    document.getElementById("texto2").innerHTML="Fechar";
                    document.getElementById("texto1").innerHTML="Mostrar";
                    document.getElementById("img2").style.display = "block";
                    document.getElementById("img1").style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
@else
<x-app-layout>
    @section('content')
    <div class="container conteudo" style="margin-top: 40px;">
        <div class="row">
            <div class="col-md-12" style="font-weight: bold; font-size: 16px; color: #00883D">
                PRINCIPAIS SERVIÇOS
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        EMISSÃO DE LICENÇAS
                                    </p>
                                </div>
                                <div class="col-md-4" style="text-align: right;">
                                    <img src="{{asset('img/emissao.svg')}}" width="35px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        RENOVAÇÃO DE LICENÇA
                                    </p>
                                </div>
                                <div class="col-md-3" style="text-align: right;">
                                    <img src="{{asset('img/renovacao.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{route('denuncias.create')}}" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        REGISTRO DE <br> DENÚNCIAS
                                    </p>
                                </div>
                                <div class="col-md-3" style="text-align: right;">
                                    <img src="{{asset('img/denuncias.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        CONSULTAS DE LICENÇAS AMBIENTAIS
                                    </p>
                                </div>
                                <div class="col-md-3" style="text-align: right;">
                                    <img src="{{asset('img/consulta.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        ACOMPANHAMENTO DE SOLICITAÇÕES
                                    </p>
                                </div>
                                <div class="col-md-4" style="text-align: right;">
                                    <img src="{{asset('img/acompanhar.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="" style="text-decoration: none; padding: 0px;">
                    <div class="card card-home">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-10">
                                    <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                        SOLICITAÇÃO DE PODA OU SUPRESSÃO DE ÁRVORES
                                    </p>
                                </div>
                                <div class="col-md-2" style="text-align: right;">
                                    <img src="{{asset('img/poda.svg')}}" width="45px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <br>
        @if ($noticias->count() > 0)  
            <div class="row">
                <div class="col-md-12" style="font-weight: bold; font-size: 16px; color: #00883D;">
                    NOTÍCIAS EM DESTAQUE
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between">
                        <div class="col-md-8" style="padding-left: 0px; padding-right: 0px">
                            <div id="carouselNoticiasCaptions" class="carousel slide" data-ride="carousel">
                                <div class="row">
                                    <div class="col-md-12">
                                        <img id="icon-prev-carousel" class="carousel-control-prev alinhar-verticalmente" href="#carouselNoticiasCaptions" role="button" data-slide="prev" src="{{asset('img/back-green-com.svg')}}" alt="" style="width: 50px">
                                        <ol class="carousel-indicators">
                                            @foreach ($noticias as $i => $noticia)
                                                @if ($i == 0)
                                                    <li data-target="#carouselNoticiasCaptions" data-slide-to="{{$i}}" class="active"></li>
                                                @else
                                                    <li data-target="#carouselNoticiasCaptions" data-slide-to="{{$i}}"></li>
                                                @endif
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach ($noticias as $i => $noticia)
                                                <div class="carousel-item @if($i == 0)active @endif">
                                                    <a class="link-carousel" href="{{$noticia->link}}" target="_blank">
                                                        <img class="img-carousel" src="{{asset('storage/'.$noticia->imagem_principal)}}" class="d-block w-100" alt="Imagem da notícia {{$noticia->titulo}}" height="400px">
                                                    </a>
                                                    <div class="carousel-caption" style="right: 0%; left: 0%">
                                                        <div style="
                                                        bottom: 0;
                                                        background: rgb(0, 0, 0);
                                                        background: rgba(0, 0, 0, 0.8);
                                                        color: #f1f1f1;
                                                        padding: 20px;
                                                        padding-bottom: 0;
                                                        padding-top: 5;">
                                                            <a class="link-carousel" href="{{$noticia->link}}" target="_blank"><h5>{{$noticia->titulo}}</h5></a>
                                                            <p style="font-size: 12px; color: rgb(202, 202, 202);">
                                                                {!! mb_strimwidth(strip_tags($noticia->texto), 0, 200, "...") !!}
                                                            </p> 
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <img id="icon-next-carousel" class="carousel-control-next alinhar-verticalmente" href="#carouselNoticiasCaptions" role="button" data-slide="next" src="{{asset('img/next-green-com.svg')}}" alt="" style="width: 50px">
                                    </div>
                                </div>                        
                            </div>
                        </div>
                        <div class="col-md-4" style="background-color: rgb(61, 61, 61)" style="padding-left: 0px; padding-right: 0px">
                            @foreach ($noticias as $i => $noticia)
                                @if($i < 3)
                                    <a href="{{$noticia->link}}" style="text-decoration:none" onmouseover="style='text-decoration:underline'" onmouseout="style='text-decoration:none'">
                                        <br>
                                        <div class="form-row col-md-12" style="font-size: 12px; color: whitesmoke">
                                            {{date('d/m/Y', strtotime($noticia->created_at))}}
                                        </div>
                                        <div class="form-row col-md-12" style="font-weight: bold; font-size: 16px; color: whitesmoke">
                                            {{$noticia->titulo}}
                                            <br>
                                            <span style="font-weight: bold; font-size: 14px;">
                                                {!! mb_strimwidth(strip_tags($noticia->texto), 0, 100, "...") !!}
                                            </span> 
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="text-align: right">
                    <a href="{{route('noticias.index')}}" style="font-weight: bold; font-style: italic; text-decoration: underline; color: #00883D">
                        Ver todas as notícias
                    </a>
                </div>
            </div>
        @endif
    </div>
    <script>
        function mostrarContato(tipo, texto, img){
            if(tipo == "mostrar1"){
                if(document.getElementById("mostrar1").style.display == "block"){
                    document.getElementById("mostrar1").style.display = "none";
                    document.getElementById("mostrar2").style.display = "block";
                    document.getElementById("texto1").innerHTML="Mostrar";
                    document.getElementById("texto2").innerHTML="Fechar";
                    document.getElementById("img1").style.display = "none";
                    document.getElementById("img2").style.display = "block";
                }else if(document.getElementById("mostrar1").style.display == "none"){
                    document.getElementById("mostrar1").style.display = "block";
                    document.getElementById("mostrar2").style.display = "none";
                    document.getElementById("texto1").innerHTML="Fechar";
                    document.getElementById("texto2").innerHTML="Mostrar";
                    document.getElementById("img1").style.display = "block";
                    document.getElementById("img2").style.display = "none";
                }
            }else if(tipo == "mostrar2"){
                if(document.getElementById("mostrar2").style.display == "block"){
                    document.getElementById("mostrar2").style.display = "none";
                    document.getElementById("mostrar1").style.display = "block";
                    document.getElementById("texto2").innerHTML="Mostrar";
                    document.getElementById("texto1").innerHTML="Fechar";
                    document.getElementById("img2").style.display = "none";
                    document.getElementById("img1").style.display = "block";
                }else if(document.getElementById("mostrar2").style.display == "none"){
                    document.getElementById("mostrar2").style.display = "block";
                    document.getElementById("mostrar1").style.display = "none";
                    document.getElementById("texto2").innerHTML="Fechar";
                    document.getElementById("texto1").innerHTML="Mostrar";
                    document.getElementById("img2").style.display = "block";
                    document.getElementById("img1").style.display = "none";
                }
            }
        }
    </script>
    @endsection
</x-app-layout>
@endguest