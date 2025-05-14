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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="{{asset('css/main.css')}}">
        <link rel="icon" type="imagem/png" href="{{asset('img/icon-page.png')}}" />
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" href="{{asset('css/sidebars.css')}}">
        @livewireStyles
    </head>
    <body class="min-h-screen antialiased" style="background-color: #e9eef5; grid-template-rows: 1fr auto;">
        <div>
            {{-- @livewire('navigation-menu') --}}
            @component('layouts.side_bar')@endcomponent

            <!-- Page Heading -->
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

        @component('layouts.footer')@endcomponent

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="{{asset('js/app.js')}}" defer></script>
        <script src="{{asset('js/main.js')}}"></script>
        <script src="{{asset('js/submit.js')}}"></script>
        <script src="{{asset('ckeditor/ckeditor.js')}}"></script>

        @livewireScripts
            @stack('scripts')
    </body>
</html>
