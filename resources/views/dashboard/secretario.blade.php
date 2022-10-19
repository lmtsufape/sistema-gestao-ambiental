<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="d-flex align-items-center">
            <div class="ps-1 mt-0 pt-0" style="font-size: 14px; color: black;">
                <span style="font-weight: bolder;">Apuração nos
                    @switch($ordenacao)
                        @case('7_dias')
                            últimos 7 dias
                            @break
                        @case('ultimo_mes')
                            últimos 30 dias
                            @break
                        @case('meses')
                            últimos 12 meses
                            @break
                        @case('anos')
                            últimos 5 anos
                            @break
                        @default
                        últimos 7 dias
                            @break
                    @endswitch
                </span>
            </div>
            <div class="dropdown">
                <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img width="35" style="padding-left: 5px; border-radius: 10px" src="{{asset('img/ordenacao.svg')}}" alt="Icone de ordenação de candidatos">
                </button>
                <div class="dropdown-menu px-2" aria-labelledby="dropdownMenuButton">
                    <div class="form-check link-ordenacao">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" @if($ordenacao == '7_dias') checked @endif>
                        <label class="form-check-label" for="flexRadioDefault1">
                            Últimos 7 dias
                        </label>
                        <a class="dropdown-item" href="{{route('welcome', ['ordenacao' => '7_dias'])}}"></a>
                    </div>
                    <div class="form-check link-ordenacao">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" @if($ordenacao == 'ultimo_mes') checked @endif>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Últimos 30 dias
                        </label>
                        <a class="dropdown-item" href="{{route('welcome', ['ordenacao' => 'ultimo_mes'])}}"></a>
                    </div>
                    <div class="form-check link-ordenacao">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" @if($ordenacao == 'meses') checked @endif>
                        <label class="form-check-label" for="flexRadioDefault3">
                            Últimos 12 meses
                        </label>
                        <a class="dropdown-item" href="{{route('welcome', ['ordenacao' => 'meses'])}}"></a>
                    </div>
                    <div class="form-check link-ordenacao">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4" @if($ordenacao == 'anos') checked @endif>
                        <label class="form-check-label" for="flexRadioDefault4">
                            Últimos 5 anos
                        </label>
                        <a class="dropdown-item" href="{{route('welcome', ['ordenacao' => 'anos'])}}"></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; margin-top: 5.2rem;">
                    <div style="font-size: 21px; margin-bottom: 10px;" class="tituloModal">
                        Filtrar período
                    </div>
                    <form id="form-fitrar-boleto" method="GET" action="{{route('welcome')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="dataDe">{{__('De')}}</label>
                                <input type="date" name="dataDe" id="dataDe" class="form-control @error('dataDe') is-invalid @enderror" value="{{old('dataDe')!=null ? old('dataDe') : $dataDe}}">

                                @error('dataDe')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="dataAte">{{__('Até')}}</label>
                                <input type="date" name="dataAte" id="dataAte" class="form-control @error('dataAte') is-invalid @enderror" value="{{old('dataAte')!=null ? old('dataAte') : $dataAte}}">

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
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <canvas id="pagamentosChart"></canvas>
        <canvas id="pagamentosPie"></canvas>
    </div>
    @push ('scripts')
        <script>
            Chart.register(ChartDataLabels);
            const dados = @json($data);

            const data = {
                labels: Object.keys(dados),
                datasets: [{
                    data: Object.values(dados),
                    backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                    hoverOffset: 0,
                }]
            };
            const options = {
                responsive: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Requerimentos de licença por status',
                    },
                    legend: {
                        display: true,
                        labels: {
                            color: 'black',
                            pointStyle: 'rectRounded',
                            usePointStyle: true,
                        }
                    },
                    datalabels: {
                        color: 'white'
                    }
                }
            };
            const config = {
                type: 'pie',
                data: data,
                options: options,
            };
            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
        </script>
        <script>
            Chart.register(ChartDataLabels);
                const dadosPagamentos = @json($pagamentos);

                const dataPagamentos = {
                    labels: Object.keys(dadosPagamentos),
                    datasets: [{
                        data: Object.values(dadosPagamentos),
                        backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                        hoverOffset: 0,
                    }]
                };
                const optionsPagamentos = {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text:  {!! json_encode($titulo) !!},
                        },
                        legend: {
                            display: false,
                        },
                    },
                    scales: { x: { title: { text: 'Data', display: true } }, y: { title: { text: 'Valor', display: true } } } ,
                };
                const configPagamentos = {
                    type: 'line',
                    data: dataPagamentos,
                    options: optionsPagamentos,
                };
                const myChartPagamentos = new Chart(
                    document.getElementById('pagamentosChart'),
                    configPagamentos
                );

                $('.link-ordenacao').click(function() {
                    window.location = this.children[2].href;
                });
        </script>
        <script>
            Chart.register(ChartDataLabels);
            const dadosPagamentosPie = @json($boletoData);

            const dataPagamentosPie = {
                labels: Object.keys(dadosPagamentosPie),
                datasets: [{
                    data: Object.values(dadosPagamentosPie),
                    backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                    hoverOffset: 0,
                }]
            };
            const optionsPagamentosPie = {
                responsive: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Boletos por status',
                    },
                    legend: {
                        display: true,
                        labels: {
                            color: 'black',
                            pointStyle: 'rectRounded',
                            usePointStyle: true,
                        }
                    },
                    datalabels: {
                        color: 'white'
                    }
                }
            };
            const configPagamentosPie = {
                type: 'pie',
                data: dataPagamentosPie,
                options: optionsPagamentosPie
            };
            const myChartPagamentosPie = new Chart(
                document.getElementById('pagamentosPie'),
                configPagamentosPie
            );
        </script>
    @endpush
    @endsection
</x-app-layout>

