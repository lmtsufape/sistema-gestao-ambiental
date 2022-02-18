<x-app-layout>

    <div class="container" style="padding-top: 5rem; padding-bottom: 8rem;">
        <div class="form-row justify-content-between">
            <div class="col-md-8">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Boletos</h4>
                    </div>
                </div>
                <div div class="form-row">
                    @if(session('success'))
                        <div class="col-md-12" style="margin-top: 5px;">
                            <div class="alert alert-success" role="alert">
                                <p>{{session('success')}}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <ul class="nav nav-tabs nav-tab-custom" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="boletos-pendentes-tab" data-toggle="tab" href="#boletos-pendentes"
                            type="button" role="tab" aria-controls="boletos-pendentes" aria-selected="true">Pendentes</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button id="link-boletos-aprovados" class="nav-link" id="boletos-aprovadas-tab" data-toggle="tab" role="tab" type="button"
                            aria-controls="boletos-aprovadas" aria-selected="false" href="#boletos-aprovadas">Pagos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" type="button" id="boletos-arquivadas-tab" data-toggle="tab" role="tab"
                            aria-controls="boletos-arquivadas" aria-selected="false" href="#boletos-arquivadas">Vencidos</button>
                    </li>
                </ul>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="tab-content tab-content-custom" id="myTabContent">
                            <div class="tab-pane fade show active" id="boletos-pendentes" role="tabpanel" aria-labelledby="boletos-pendentes-tab">
                                <table class="table mytable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Empresa/serviço</th>
                                            <th scope="col" style="text-align: center">Valor</th>
                                            <th scope="col" style="text-align: center">Requerimento</th>
                                            <th scope="col" style="text-align: center">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendentes as $boleto)
                                            <tr>
                                                <td>{{($loop->iteration)}}</td>
                                                <td style="text-align: center">{{ $boleto->requerimento->empresa->nome }}</td>
                                                <td style="text-align: center">
                                                    R$ {{number_format($boleto->requerimento->valor, 2, ',', ' ')}} <a href="{{route('boleto.create', ['requerimento' => $boleto->requerimento])}}" target="_blanck"><img src="{{asset('img/boleto.png')}}" alt="Baixar boleto de cobrança" width="40px;" style="display: inline;"></a>
                                                </td>
                                                <td style="text-align: center">
                                                    @if($boleto->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                                        {{__('Primeira licença')}}
                                                    @elseif($boleto->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                                        {{__('Renovação')}}
                                                    @elseif($boleto->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                                        {{__('Autorização')}}
                                                    @endif
                                                </td>
                                                <td>{{$boleto->created_at->format('d/m/Y H:i')}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($pendentes->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhum boleto pendente
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="boletos-aprovadas" role="tabpanel" aria-labelledby="boletos-aprovadas-tab">
                                <table class="table mytable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Empresa/serviço</th>
                                            <th scope="col" style="text-align: center">Valor</th>
                                            <th scope="col" style="text-align: center">Requerimento</th>
                                            <th scope="col" style="text-align: center">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pagos as $boleto)
                                            <tr>
                                                <td>{{($loop->iteration)}}</td>
                                                <td style="text-align: center">{{ $boleto->requerimento->empresa->nome }}</td>
                                                <td style="text-align: center">
                                                    R$ {{number_format($boleto->requerimento->valor, 2, ',', ' ')}} <a href="{{route('boleto.create', ['requerimento' => $boleto->requerimento])}}" target="_blanck"><img src="{{asset('img/boleto.png')}}" alt="Baixar boleto de cobrança" width="40px;" style="display: inline;"></a>
                                                </td>
                                                <td style="text-align: center">
                                                    @if($boleto->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                                        {{__('Primeira licença')}}
                                                    @elseif($boleto->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                                        {{__('Renovação')}}
                                                    @elseif($boleto->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                                        {{__('Autorização')}}
                                                    @endif
                                                </td>
                                                <td>{{$boleto->created_at->format('d/m/Y H:i')}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($pagos->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhum boleto pago
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="boletos-arquivadas" role="tabpanel" aria-labelledby="boletos-arquivadas-tab">
                                <table class="table mytable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Empresa/serviço</th>
                                            <th scope="col" style="text-align: center">Valor</th>
                                            <th scope="col" style="text-align: center">Requerimento</th>
                                            <th scope="col" style="text-align: center">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vencidos as $boleto)
                                            <tr>
                                                <td>{{($loop->iteration)}}</td>
                                                <td style="text-align: center">{{ $boleto->requerimento->empresa->nome }}</td>
                                                <td style="text-align: center">
                                                    R$ {{number_format($boleto->requerimento->valor, 2, ',', ' ')}} <a href="{{route('boleto.create', ['requerimento' => $boleto->requerimento])}}" target="_blanck"><img src="{{asset('img/boleto.png')}}" alt="Baixar boleto de cobrança" width="40px;" style="display: inline;"></a>
                                                </td>
                                                <td style="text-align: center">
                                                    @if($boleto->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['primeira_licenca'])
                                                        {{__('Primeira licença')}}
                                                    @elseif($boleto->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['renovacao'])
                                                        {{__('Renovação')}}
                                                    @elseif($boleto->requerimento->tipo == \App\Models\Requerimento::TIPO_ENUM['autorizacao'])
                                                        {{__('Autorização')}}
                                                    @endif
                                                </td>
                                                <td>{{$boleto->created_at->format('d/m/Y H:i')}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($vencidos->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhum boleto vencido
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #f8f9fa; border-radius: 00.5rem; margin-top: 2.6rem;">
                    <form id="baixar-relatorio" method="GET" action="{{route('gerar.pdf.boletos')}}">
                        @csrf
                        <input type="hidden" value="{{$filtro}}" name="filtro">
                        <input type="hidden" value="{{$dataDe}}" name="dataDe">
                        <input type="hidden" value="{{$dataAte}}" name="dataAte">
                        <div class="form-row justify-content-center">
                            <div class="col-md-5 form-group">
                                <button id="submitBaixarRelatorio" type="submit" class="btn btn-success btn-color-dafault" form="baixar-relatorio">Baixar relatório</button>
                            </div>
                        </div>
                    </form>
                    <form id="form-fitrar-boleto" method="GET" action="{{route('boletos.index')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="filtro">{{__('Filtrar por')}}</label>
                                <select class="form-select form-select-sm form-control" name="filtro" aria-label=".form-select-sm example">
                                    <option value="">-- Selecione o tipo de data para a filtragem --</option>
                                    <option value="criado" @if($filtro != null && $filtro == 'criado') selected @endif>Criação do boleto</option>
                                    <option value="vencimento" @if($filtro != null && $filtro == 'vencimento') selected @endif>Vencimento</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="dataDe">{{__('De:')}}</label>
                                <input type="datetime-local" name="dataDe" id="dataDe" class="form-control @error('dataDe') is-invalid @enderror" value="{{old('dataDe')!=null ? old('dataDe') : $dataDe}}">

                                @error('dataDe')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="dataAte">{{__('Até:')}}</label>
                                <input type="datetime-local" name="dataAte" id="dataAte" class="form-control @error('dataAte') is-invalid @enderror" value="{{old('dataAte')!=null ? old('dataAte') : $dataAte}}">

                                @error('dataAte')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="col-md-6 form-group">
                                <button type="submit" id="submeterFormBotao" class="btn btn-success btn-color-dafault submeterFormBotao" form="form-fitrar-boleto" style="width: 100%">Aplicar</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        function refreshPage(){
            var form = document.getElementById("baixar-relatorio");
            document.getElementById("submitBaixarRelatorio").addEventListener("click", function () {
                form.submit();
            });
            sleep(2000);
            .then(() => window.location.reload();
        } 
    </script>
</x-app-layout>
