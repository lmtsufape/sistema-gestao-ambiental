<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-12">
                        <h4 class="card-title">Criar uma visita</h4>
                        <h6 class="card-subtitle mb-2 text-muted"><a class="text-muted" href="{{route('visitas.index', ['filtro' => 'requerimento', 'ordenacao' => 'data_marcada', 'ordem' => 'DESC'])}}">Visitas</a> > Criar visita</h6>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" href="{{route('visitas.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-borda-esquerda" style="width: 100%;">
                    <div class="card-body">
                        <form method="POST" id="criar-visita" action="{{route('visitas.store')}}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label style="font-size:19px;margin-top:10px; margin-bottom:-5px;">DADOS DA VISITA</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="data_marcada">{{ __('Data') }}<span style="color: red; font-weight: bold;">*</span></label>
                                    <input class="form-control @error('data_marcada') is-invalid @enderror" type="date"  id="data_marcada" name="data_marcada" required autofocus autocomplete="data_marcada">

                                    @error('data_marcada')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="requerimento">{{__('Selecione um requerimento')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="requerimento" id="requerimento" class="form-control @error('requerimento') is-invalid @enderror" required onchange="selecionarAnalista(this)">
                                        <option value="">-- {{__('Selecione um requerimento')}} --</option>
                                        @foreach ($requerimentos as $requerimento)
                                            <option value="{{$requerimento->id}}">{{$requerimento->empresa->nome}} @if($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                                {{__('(primeira licença)')}}
                                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                                {{__('(renovação)')}}
                                            @elseif($requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                                {{__('(autorização)')}}
                                            @endif</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="analista">{{__('Selecione o analista da visita')}}<span style="color: red; font-weight: bold;">*</span></label>
                                    <select name="analista" id="analista" class="form-control @error('analista') is-invalid @enderror" required>
                                        <option value="">-- {{__('Selecione um analista')}} --</option>
                                        @foreach ($analistas as $analista)
                                            <option @if(old('analista') == $analista->id) selected @endif value="{{$analista->id}}">{{$analista->name}}</option>
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
                                <button type="submit" class="btn btn-success btn-color-dafault  submeterFormBotao" form="criar-visita" style="width: 100%">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push ('scripts')
        <script>
            function selecionarAnalista(requerimento){
                id = requerimento.value;
                $.ajax({
                    url:"{{route('requerimentos.get.analista')}}",
                    type:"get",
                    data: {"requerimento_id": id},
                    dataType:'json',
                    success: function(requerimento) {
                        if(requerimento.analista_atribuido != null){
                            $("#analista").val(requerimento.analista_atribuido.id).change();
                        }else{
                            $("#analista").val('').change();
                        }
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
