@guest
<x-guest-layout>
    @include('pages.noticia')
</x-guest-layout>
@else
<x-app-layout>
    @section('content')
        @can('isSecretario', \App\Models\User::class)
            @foreach ($noticias as $noticia)
                <!-- Modal deletar noticia -->
                <div class="modal fade" id="modal-deletar-noticia-{{$noticia->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Deletar notícia {{$noticia->titulo}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <form id="deletar-noticia-{{$noticia->id}}" method="POST" action="{{route('noticias.destroy', ['noticia' => $noticia])}}">
                                @csrf
                                @method('delete')
                                Tem certeza que desenha deletar {{$noticia->titulo}}?
                            </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                        <button type="submit" class="btn btn-danger" form="deletar-noticia-{{$noticia->id}}">Sim</button>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach
        @endcan
        @include('pages.noticia')
    @endsection
</x-app-layout>
@endguest
