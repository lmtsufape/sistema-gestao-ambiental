<x-app-layout>
    <style>
        .section-subtitle{
            color: #00883D;
            display: flex;
            justify-content: left;
            margin: 1rem 5rem 1rem 0.5rem;
            padding-left: 0.5rem;
            border-left: 3px solid #198754
        }

        .card-alto{
            height: 300px;

        }
    </style>
    @section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h4 class="card-title">Dashboard estatístico</h4>
            </div>
        </div>
        <div class="shadow-sm p-2 px-3 mb-5" style="background-color: #ffffff; border-radius: 00.5rem; width: 100%">
            <div style="font-size: 21px; margin-bottom: 10px;" class="tituloModal">
                Filtrar por período
            </div>
            <!-- AQUI QUE ROTA -->
            <form action="{{route('dashboard')}}" method="GET">
                @csrf
                <div class="form-row">
                    <div class="col-md-4 form-group">
                        <label for="dataDe">{{__('De')}}</label>
                        <input type="date" name="dataDe" id="dataDe" class="form-control @error('dataDe') is-invalid @enderror" value="{{old('dataDe')!=null ? old('dataDe') : $dataDe}}">

                        @error('dataDe')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="dataAte">{{__('Até')}}</label>
                        <input type="date" name="dataAte" id="dataAte" class="form-control @error('dataAte') is-invalid @enderror" value="{{old('dataAte')!=null ? old('dataAte') : $dataAte}}">

                        @error('dataAte')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-center mt-3">
                        <button type="submit" id="submeterFormBotao" class="btn btn-success btn-color-dafault submeterFormBotao w-75 rounded">Filtrar</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="d-flex justify-content-center">
                <a class="btn @if($ordenacao == '7_dias') btn-primary @else btn-outline-secondary @endif rounded-pill mx-4 px-4" href="{{route('dashboard', ['ordenacao' => '7_dias'])}}">Últimos 7 dias</a>
                <a class="btn @if($ordenacao == 'ultimo_mes') btn-primary @else btn-outline-secondary @endif rounded-pill mx-4 px-4" href="{{route('dashboard', ['ordenacao' => 'ultimo_mes'])}}"> Últimos 30 dias</a>
                <a class="btn @if($ordenacao == 'meses') btn-primary @else btn-outline-secondary @endif rounded-pill mx-4 px-4" href="{{route('dashboard', ['ordenacao' => 'meses'])}}">Últimos 12 meses</a>
                <a class="btn @if($ordenacao == 'anos') btn-primary @else btn-outline-secondary @endif rounded-pill mx-4 px-4" href="{{route('dashboard', ['ordenacao' => 'anos'])}}">Últimos 5 anos</a>
            </div>
        </div>
        <div class="text-center">
            <h5 class="section-subtitle">📁 Requerimentos e Licenças</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-alto p-4 rounded-5 shadow">
                        @if (!collect($data)->every(fn($valor) => $valor === 0))
                            <canvas id="requerimentosChart"></canvas>
                        @else
                            <p>Nenhum requerimento criado no período informado</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-alto p-4 rounded-5 shadow">
                        @if ($licencasData->count() > 0)
                            <canvas id="licencasChart"></canvas>
                        @else
                            <p>Nenhuma licença gerada no período informado</p>
                        @endif
                    </div>
                </div>
            </div>
            <h5 class="section-subtitle">🌱 Meio Ambiente</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-alto p-4 rounded-5 shadow">
                        @if ($mudasData->count() > 0)
                            <canvas id="mudasChart"></canvas>
                        @else
                            <p>Nenhuma solicitação de muda criada no período informado</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-alto p-4 rounded-5 shadow">
                        @if ($podasData->count() > 0)
                            <canvas id="podasChart"></canvas>
                        @else
                            <p>Nenhuma solicitação de poda/supressão criada no período informado</p>
                        @endif
                    </div>
                </div>
            </div>
            <h5 class="section-subtitle">📄 Denúncias</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-alto p-4 rounded-5 shadow">
                        @if ($denunciasData->count() > 0)
                            <canvas id="denunciasChart"></canvas>
                        @else
                            <p>Nenhuma denúncia registrada no período informado</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-alto rounded-5 shadow d-flex flex-column align-items-center justify-content-center">
                        @if ($notificacoes->count() > 0)
                            <h2>
                                Total de notificações
                            </h2>
                            <h1>
                                <strong style="color: #00883D;">{{ $notificacoes->count() }}</strong>
                            </h1>
                            <p>
                                Quantidade de notificações realizadas no período informado.
                            </p>
                        @else
                            <h2 style="text-align: center; font-size: 16px; color: #273746;">Nenhuma notificação realizada no período informado</h2>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <h5 class="section-subtitle mt-5 mb-4 text-center">💰 Boletos</h5>
                    <div class="card py-4">
                        <canvas id="pagamentosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push ('scripts')
        <script>
            Chart.register(ChartDataLabels);
            const dados = @json($data);
            Chart.register(ChartDataLabels);
            const dadosLicencasPie = @json($licencasData);
            Chart.register(ChartDataLabels);
            const dadosPagamentos = @json($pagamentos);
            Chart.register(ChartDataLabels);
            const dadosPagamentosPie = @json($boletoData);
            Chart.register(ChartDataLabels);
            const dadosMudasPie = @json($mudasData);
            Chart.register(ChartDataLabels);
            const dadosPodasPie = @json($podasData);
            Chart.register(ChartDataLabels);
            const dadosDenunciasPie = @json($denunciasData);

            function chartConfigs(dados, texto){
                return  {
                    type: 'bar',
                    data:{
                        labels: Object.keys(dados),
                        datasets: [{
                            data: Object.values(dados),
                            backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                            borderRadius: 6
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: `${texto} (${Object.values(dados).reduce((total, valor) => total + valor, 0)})`,
                                color: '#333333',
                                align: 'start',
                                font: {
                                    size: 16
                                }
                            },
                            legend: {
                                display: false,

                            },
                            datalabels: {
                                color: 'white'
                            }
                        },
                        scales: {
                            y: {
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                                }
                            },
                            beginAtZero: true
                            }
                        }
                    },
                }
            }

            const myChart = new Chart(
                document.getElementById('requerimentosChart'),
                chartConfigs(dados ,'Requerimentos de licença por status')
            );
            const myChartLicencasPie = new Chart(
                document.getElementById('licencasChart'),
                chartConfigs(dadosLicencasPie, 'Licenças por tipo')
            );

            const myChartPagamentos = new Chart(
                document.getElementById('pagamentosPie'),
                chartConfigs(dadosPagamentos, {!! json_encode($titulo) !!})
            );

            const myChartPagamentosPie = new Chart(
                document.getElementById('pagamentosChart'),
                chartConfigs(dadosPagamentosPie, 'Boletos por status')
            );

            const myChartMudasPie = new Chart(
                document.getElementById('mudasChart'),
                chartConfigs(dadosMudasPie, 'Solicitações de mudas por status')
            );

            const myChartPodasPie = new Chart(
                document.getElementById('podasChart'),
                chartConfigs(dadosPodasPie, 'Solicitações de podas por status')
            );
            const myChartDenunciasPie = new Chart(
                    document.getElementById('denunciasChart'),
                    chartConfigs(dadosDenunciasPie, 'Registros de denúncias por status')
                );

            $('.link-ordenacao').click(function() {
                window.location = this.children[2].href;
            });
        </script>
    @endpush
    @endsection
</x-app-layout>

