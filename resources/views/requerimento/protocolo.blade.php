<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-sm-12">
                <div class="form-row">
                    <div class="col-md-12" style="padding-top: 15px;">
                        <h4 class="card-title">Protocolo do requerimento nº {{$requerimento->id}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('requerimentos.index', 'atuais')}}">Requerimentos</a> > Número do protocolo: {{$requerimento->protocolo}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <iframe src="{{route('requerimentos.protocolo.baixar', $requerimento)}}" frameborder="0" width="100%" height="700px"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
