@guest
<x-guest-layout>
    @include('pages.legislacao')
</x-guest-layout>
@else
<x-app-layout>
    @section('content')
        @include('pages.legislacao')
    @endsection
</x-app-layout>
@endguest
