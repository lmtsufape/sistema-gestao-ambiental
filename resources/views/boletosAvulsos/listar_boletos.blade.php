<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-between">
            <div class="col-md-8">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Pagamentos {{$filtragem}} </h4>
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

                <form action="{{route('boletosAvulsos.listar_boletos', 'pendentes')}}" method="get">
                    @csrf
                    <div class="form-row mb-3">
                        <div class="col-md-7">
                            <input type="text" class="form-control w-100" name="buscar" placeholder="Digite o nome da Empresa" value="{{ $busca }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn" style="background-color: #00883D; color: white;">Buscar</button>
                        </div>
                    </div>
                </form>

                <ul class="nav nav-tabs nav-tab-custom" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if($filtragem == 'pendentes') active @endif" id="boletos-pendentes-tab"
                            type="button" role="tab" @if($filtragem == 'pendentes') aria-selected="true" @endif href="{{route('boletosAvulsos.listar_boletos', 'pendentes')}}">Pendentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($filtragem == 'pagos') active @endif" id="boletos-aprovadas-tab"
                            type="button" role="tab" @if($filtragem == 'pagos') aria-selected="true" @endif href="{{route('boletosAvulsos.listar_boletos', 'pagos')}}">Pagos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($filtragem == 'vencidos') active @endif" id="boletos-arquivadas-tab"
                            type="button" role="tab" @if($filtragem == 'vencidos') aria-selected="true" @endif href="{{route('boletosAvulsos.listar_boletos', 'vencidos')}}">Vencidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($filtragem == 'cancelados') active @endif" id="boletos-cancelados-tab"
                            type="button" role="tab" @if($filtragem == 'cancelados') aria-selected="true" @endif href="{{route('boletosAvulsos.listar_boletos', 'cancelados')}}">Cancelados</a>
                    </li>
                </ul>
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="tab-content tab-content-custom" id="myTabContent">
                            <div class="tab-pane fade show active" id="boletos-pendentes" role="tabpanel" aria-labelledby="boletos-pendentes-tab">
                                <div class="table-responsive">
                                <table class="table mytable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col" style="text-align: center">Empresa/serviço</th>
                                            <th scope="col" style="text-align: center">Valor</th>
                                            <th scope="col" style="text-align: center">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pagamentos as $boleto)
                                            <tr>
                                                <th>{{ ($pagamentos->currentpage()-1) * $pagamentos->perpage() + $loop->index + 1 }}</th>
                                                <td style="text-align: center">{{ $boleto->empresa->nome }}</td>
                                                <td style="text-align: center">
                                                    R$ {{number_format($boleto->valor_boleto, 2, ',', ' ')}} @if($boleto->URL) <a href="{{$boleto->URL}}" target="_blanck"><img src="{{asset('img/boleto.png')}}" alt="Baixar boleto de cobrança" width="40px;" style="display: inline;"></a> @endif
                                                </td>
                                                <td>{{$boleto->created_at->format('d/m/Y H:i')}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                @if($pagamentos->first() == null)
                                    <div class="col-md-12 text-center" style="font-size: 18px;">
                                        Nenhum boleto @switch($filtragem) @case('pendentes')pendente @break @case('pagos')pago @break @case('vencidos')vencido @break @case('cancelados')cancelado @break @endswitch
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row justify-content-center">
                    <div class="col-md-10">
                        {{$pagamentos->links()}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 5.2rem;">
                    <div style="font-size: 21px; margin-bottom: 10px;" class="tituloModal">
                        Baixar relatório
                    </div>
                    <form id="form-fitrar-boleto" method="GET" action="{{route('boletosAvulsos.listar_boletos', $filtragem)}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="filtro">{{__('Filtrar por')}}</label>
                                <select class="form-select form-select-sm form-control" name="filtro" aria-label=".form-select-sm example">
                                    <option value="">-- Selecione o tipo de data --</option>
                                    <option value="criado" @if($filtro != null && $filtro == 'criado') selected @endif>Criação do boleto</option>
                                    <option value="vencimento" @if($filtro != null && $filtro == 'vencimento') selected @endif>Vencimento</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="dataDe">{{__('De')}}</label>
                                <input type="datetime-local" name="dataDe" id="dataDe" class="form-control @error('dataDe') is-invalid @enderror" value="{{old('dataDe')!=null ? old('dataDe') : $dataDe}}">

                                @error('dataDe')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="dataAte">{{__('Até')}}</label>
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
                                <button type="submit" id="submeterFormBotao" class="btn btn-success btn-color-dafault submeterFormBotao" form="form-fitrar-boleto" style="width: 100%">Filtrar</button>
                            </div>
                        </div>
                        <div style="border-bottom:solid 3px #e0e0e0; margin-top: -1%; margin-bottom: 3%;">
                        </div>
                    </form>
                    <form id="baixar-relatorio" method="GET" action="{{route('gerar.pdf.boletosAvulsos')}}">
                        @csrf
                        <input type="hidden" value="{{$filtro}}" name="filtro">
                        <input type="hidden" value="{{$dataDe}}" name="dataDe">
                        <input type="hidden" value="{{$dataAte}}" name="dataAte">

                        <div class="form-row justify-content-center mb-2">
                            <button id="submitBaixarRelatorio" type="submit" class="btn btn-success btn-color-dafault" form="baixar-relatorio">Fazer download</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push ('scripts')
        <script>
            function refreshPage(){
                var form = document.getElementById("baixar-relatorio");
                document.getElementById("submitBaixarRelatorio").addEventListener("click", function () {
                    form.submit();
                });
                sleep(2000).then(() => window.location.reload());
            }
        </script>
    @endpush
    @endsection
</x-app-layout>
