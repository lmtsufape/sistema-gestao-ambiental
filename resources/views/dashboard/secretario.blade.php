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
        </div>
        <div class="row">
            <div class="col-md-12">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <canvas id="pagamentosChart"></canvas>
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
    @endpush
    @endsection
</x-app-layout>

