<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{config('app.name', 'Laravel')}}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="icon" type="imagem/png" href="{{asset('img/icon-page.png')}}" />
        @livewireStyles
    </head>
    <body class="min-h-screen" style="grid-template-rows: auto 1fr auto;">
        <header>
            @component('layouts.nav_bar')@endcomponent
        </header>
        <div class="antialiased">
            <!-- Page Heading -->

            <div class="">
                @if (isset($header))
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            @stack('modals')
        </div>
        @component('layouts.footer')@endcomponent

        <!-- Scripts -->
        <script src="{{asset('js/app.js')}}" defer></script>
        <script src="{{asset('js/main.js')}}"></script>
        <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
        @livewireScripts
        @stack('scripts')
        <script>
            $(document).ready(function () {
                var btn = document.getElementsByClassName("submeterFormBotao");
                if(btn.length > 0){
                    $(document).on('submit', 'form', function() {
                        $('button').attr('disabled', 'disabled');
                        for (var i = 0; i < btn.length; i++) {
                            btn[i].textContent = 'Aguarde...';
                            btn[i].style.backgroundColor = btn.style.backgroundColor + 'd8';
                        }
                    });
                }
            })
        </script>
    </body>
</html>
