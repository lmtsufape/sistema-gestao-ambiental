@guest
    <x-guest-layout>
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
                                    <div class="col-md-9">
                                        <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                            EMISSÃO DE LICENÇAS
                                        </p>
                                    </div>
                                    <div class="col-md-3" style="text-align: right;">
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
                                    <div class="col-md-9">
                                        <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                            ACOMPANHAMENTO DE SOLICITAÇÕES
                                        </p>
                                    </div>
                                    <div class="col-md-3" style="text-align: right;">
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
                                    <div class="col-md-2">
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
                                            <img id="icon-prev-carousel" class="carousel-control-prev alinhar-verticalmente" href="#carouselNoticiasCaptions" role="button" data-slide="prev"
                                                 src="{{asset('img/back-green-com.svg')}}" alt="" style="width: 50px">
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
                                                            <img class="img-carousel" src="{{asset('storage/'.$noticia->imagem_principal)}}" class="d-block w-100"
                                                                 alt="Imagem da notícia {{$noticia->titulo}}" height="400px">
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
                                            <img id="icon-next-carousel" class="carousel-control-next alinhar-verticalmente" href="#carouselNoticiasCaptions" role="button" data-slide="next"
                                                 src="{{asset('img/next-green-com.svg')}}" alt="" style="width: 50px">
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
            function mostrarContato(tipo, texto, img) {
                if (tipo == "mostrar1") {
                    if (document.getElementById("mostrar1").style.display == "block") {
                        document.getElementById("mostrar1").style.display = "none";
                        document.getElementById("mostrar2").style.display = "block";
                        document.getElementById("texto1").innerHTML = "Mostrar";
                        document.getElementById("texto2").innerHTML = "Fechar";
                        document.getElementById("img1").style.display = "none";
                        document.getElementById("img2").style.display = "block";
                    } else if (document.getElementById("mostrar1").style.display == "none") {
                        document.getElementById("mostrar1").style.display = "block";
                        document.getElementById("mostrar2").style.display = "none";
                        document.getElementById("texto1").innerHTML = "Fechar";
                        document.getElementById("texto2").innerHTML = "Mostrar";
                        document.getElementById("img1").style.display = "block";
                        document.getElementById("img2").style.display = "none";
                    }
                } else if (tipo == "mostrar2") {
                    if (document.getElementById("mostrar2").style.display == "block") {
                        document.getElementById("mostrar2").style.display = "none";
                        document.getElementById("mostrar1").style.display = "block";
                        document.getElementById("texto2").innerHTML = "Mostrar";
                        document.getElementById("texto1").innerHTML = "Fechar";
                        document.getElementById("img2").style.display = "none";
                        document.getElementById("img1").style.display = "block";
                    } else if (document.getElementById("mostrar2").style.display == "none") {
                        document.getElementById("mostrar2").style.display = "block";
                        document.getElementById("mostrar1").style.display = "none";
                        document.getElementById("texto2").innerHTML = "Fechar";
                        document.getElementById("texto1").innerHTML = "Mostrar";
                        document.getElementById("img2").style.display = "block";
                        document.getElementById("img1").style.display = "none";
                    }
                }
            }
        </script>
    </x-guest-layout>
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
                                        <div class="col-md-9">
                                            <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                                EMISSÃO DE LICENÇAS
                                            </p>
                                        </div>
                                        <div class="col-md-3" style="text-align: right;">
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
                        <button style="text-decoration: none; padding: 0px;" data-toggle="modal" data-target="#consultaLicencaModal">
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
                        </button>
                    </div>
                    <div class="col-md-4">
                        <a href="" style="text-decoration: none; padding: 0px;">
                            <div class="card card-home">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-9">
                                            <p style="font-weight: bold; font-size: 18px; margin-bottom: 0px;">
                                                ACOMPANHAMENTO DE SOLICITAÇÕES
                                            </p>
                                        </div>
                                        <div class="col-md-3" style="text-align: right;">
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
                                        <div class="col-md-2" style="padding-left: 0px">
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
                                                <img id="icon-prev-carousel" class="carousel-control-prev alinhar-verticalmente" href="#carouselNoticiasCaptions" role="button" data-slide="prev"
                                                     src="{{asset('img/back-green-com.svg')}}" alt="" style="width: 50px">
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
                                                                <img class="img-carousel" src="{{asset('storage/'.$noticia->imagem_principal)}}" class="d-block w-100"
                                                                     alt="Imagem da notícia {{$noticia->titulo}}" height="400px">
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
                                                <img id="icon-next-carousel" class="carousel-control-next alinhar-verticalmente" href="#carouselNoticiasCaptions" role="button" data-slide="next"
                                                     src="{{asset('img/next-green-com.svg')}}" alt="" style="width: 50px">
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
                function mostrarContato(tipo, texto, img) {
                    if (tipo == "mostrar1") {
                        if (document.getElementById("mostrar1").style.display == "block") {
                            document.getElementById("mostrar1").style.display = "none";
                            document.getElementById("mostrar2").style.display = "block";
                            document.getElementById("texto1").innerHTML = "Mostrar";
                            document.getElementById("texto2").innerHTML = "Fechar";
                            document.getElementById("img1").style.display = "none";
                            document.getElementById("img2").style.display = "block";
                        } else if (document.getElementById("mostrar1").style.display == "none") {
                            document.getElementById("mostrar1").style.display = "block";
                            document.getElementById("mostrar2").style.display = "none";
                            document.getElementById("texto1").innerHTML = "Fechar";
                            document.getElementById("texto2").innerHTML = "Mostrar";
                            document.getElementById("img1").style.display = "block";
                            document.getElementById("img2").style.display = "none";
                        }
                    } else if (tipo == "mostrar2") {
                        if (document.getElementById("mostrar2").style.display == "block") {
                            document.getElementById("mostrar2").style.display = "none";
                            document.getElementById("mostrar1").style.display = "block";
                            document.getElementById("texto2").innerHTML = "Mostrar";
                            document.getElementById("texto1").innerHTML = "Fechar";
                            document.getElementById("img2").style.display = "none";
                            document.getElementById("img1").style.display = "block";
                        } else if (document.getElementById("mostrar2").style.display == "none") {
                            document.getElementById("mostrar2").style.display = "block";
                            document.getElementById("mostrar1").style.display = "none";
                            document.getElementById("texto2").innerHTML = "Fechar";
                            document.getElementById("texto1").innerHTML = "Mostrar";
                            document.getElementById("img2").style.display = "block";
                            document.getElementById("img1").style.display = "none";
                        }
                    }
                }
            </script>
        @endsection
    </x-app-layout>

    <div class="modal fade" id="consultaLicencaModal" tabindex="-1" role="dialog" aria-labelledby="consultaLicencaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #00883D; color: white;">
                    <h5 class="modal-title" id="exampleModalLabel">Seleciona a Empresa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="novo-requerimento-form" method="GET" action="{{route('empresa.licenca.index')}}">
                    <div class="modal-body">
                        <div>
                            <label for="selectEmpresa"> Empresas Cadastradas <span style="color: red">*</span></label>
                            <select class="form-control" id="selectEmpresa" name="empresa">
                                @foreach($empresas as $empresa)
                                    <option value="{{$empresa->id}}">{{$empresa->nome}} - {{$empresa->cpf_cnpj}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endguest
