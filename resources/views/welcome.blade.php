@guest
<x-guest-layout>
    @include('pages.welcome')
</x-guest-layout>
@else
<x-app-layout>
    @section('content')
        @can('isRequerente', \App\Models\User::class)
            @include('pages.welcome')
        @elsecan('isSecretario', \App\Models\User::class)
            @include('dashboard.secretario')
        @endcan
    @endsection
</x-app-layout>
@endguest
