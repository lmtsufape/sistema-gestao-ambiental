<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <iframe src="{{route('requerimentos.protocolo.baixar', $requerimento)}}" frameborder="0" width="100%" height="500px"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
