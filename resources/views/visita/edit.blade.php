<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Editar a visita à empresa {{$visita->requerimento->empresa->nome}}</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('visitas.index', ['filtro' => 'requerimento', 'ordenacao' => 'data_marcada', 'ordem' => 'DESC'])}}">Visitas</a> > Editar visita</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" @if ($verRequerimento ?? '') href="{{route('requerimento.visitas', ['id' => $visita->requerimento])}}" @else href="{{route('visitas.index')}}" @endif>
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-12">
                        @if(session('error'))
                            <div class="col-md-12" style="margin-top: 5px;">
                                <div class="alert alert-danger" role="alert">
                                    <p>{{session('error')}}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <form method="POST" id="editar-visita" action="{{route('visitas.update', $visita->id)}}">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="data_marcada">{{ __('Data') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input type="date" class="form-control @error('data_marcada') is-invalid @enderror" id="data_marcada" name="data_marcada" value="{{old('data_marcada')!=null ? old('data_marcada') : $visita->data_marcada}}" required autofocus autocomplete="data_marcada">
                                    @error('data_marcada')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="requerimento">{{__('Selecione um requerimento')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="requerimento"  id="requerimento" required class="form-control @error('requerimento') is-invalid @enderror">
                                        <option value="">-- {{__('Selecione um requerimento')}} --</option>
                                        @if (old('requerimento') != null)
                                            @foreach ($requerimentos as $requerimento)
                                                <option value="{{$requerimento->id}}" @if(old('requerimento') == $requerimento->id) selected @endif>{{$requerimento->empresa->nome}} @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                                    {{__('(primeira licença)')}}
                                                @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                                    {{__('(renovação)')}}
                                                @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                                    {{__('(autorização)')}}
                                                @endif</option>
                                            @endforeach
                                        @else
                                            @foreach ($requerimentos as $requerimento)
                                                <option value="{{$requerimento->id}}" @if($visita->requerimento->id == $requerimento->id) selected @endif>{{$requerimento->empresa->nome}} @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                                    {{__('(primeira licença)')}}
                                                @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                                    {{__('(renovação)')}}
                                                @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                                    {{__('(autorização)')}}
                                                @endif</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="analista">{{__('Selecione o analista da visita')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="analista" id="analista" class="form-control @error('analista') is-invalid @enderror" required>
                                        <option value="">-- {{__('Selecione um analista')}} --</option>
                                        @foreach ($analistas as $analista)
                                            <option @if(old('analista', $visita->analista->id) == $analista->id) selected @endif value="{{$analista->id}}">{{$analista->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('analista')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="form-row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6" style="text-align: right">
                                <button type="submit" class="btn btn-success btn-color-dafault  submeterFormBotao" form="editar-visita" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
