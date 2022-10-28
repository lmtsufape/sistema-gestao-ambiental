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
            <div class="col-md-6">
                <canvas id="requerimentosChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="licencasChart"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <canvas id="mudasChart"></canvas>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <canvas id="podasChart"></canvas>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        @if ($denunciasData->count() > 0)
        <div class="row">
            <div class="col-md-6">
                <canvas id="denunciasChart"></canvas>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-md-12">
                Nenhuma denúncia no período informado
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <canvas id="pagamentosPie"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <canvas id="pagamentosChart"></canvas>
            </div>
        </div>

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
                document.getElementById('requerimentosChart'),
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

        <script>
            Chart.register(ChartDataLabels);
            const dadosMudasPie = @json($mudasData);

            const dataMudasPie = {
                labels: Object.keys(dadosMudasPie),
                datasets: [{
                    data: Object.values(dadosMudasPie),
                    backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                    hoverOffset: 0,
                }]
            };
            const optionsMudasPie = {
                responsive: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Solicitações de mudas por status',
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
            const configMudasPie = {
                type: 'pie',
                data: dataMudasPie,
                options: optionsMudasPie
            };
            const myChartMudasPie = new Chart(
                document.getElementById('mudasChart'),
                configMudasPie
            );
        </script>

        <script>
            Chart.register(ChartDataLabels);
            const dadosPodasPie = @json($podasData);

            const dataPodasPie = {
                labels: Object.keys(dadosPodasPie),
                datasets: [{
                    data: Object.values(dadosPodasPie),
                    backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                    hoverOffset: 0,
                }]
            };
            const optionsPodasPie = {
                responsive: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Solicitações de podas por status',
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
            const configPodasPie = {
                type: 'pie',
                data: dataPodasPie,
                options: optionsPodasPie
            };
            const myChartPodasPie = new Chart(
                document.getElementById('podasChart'),
                configPodasPie
            );
        </script>

        <script>
            Chart.register(ChartDataLabels);
            const dadosDenunciasPie = @json($denunciasData);
            if (dadosDenunciasPie.length > 0) {
                const dataDenunciasPie = {
                    labels: Object.keys(dadosDenunciasPie),
                    datasets: [{
                        data: Object.values(dadosDenunciasPie),
                        backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                        hoverOffset: 0,
                    }]
                };
                const optionsDenunciasPie = {
                    responsive: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Registros de denúncias por status',
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
                const configDenunciasPie = {
                    type: 'pie',
                    data: dataDenunciasPie,
                    options: optionsDenunciasPie
                };
                const myChartDenunciasPie = new Chart(
                    document.getElementById('denunciasChart'),
                    configDenunciasPie
                );
            }
        </script>

        <script>
            Chart.register(ChartDataLabels);
            const dadosLicencasPie = @json($licencasData);

            const dataLicencasPie = {
                labels: Object.keys(dadosLicencasPie),
                datasets: [{
                    data: Object.values(dadosLicencasPie),
                    backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                    hoverOffset: 0,
                }]
            };
            const optionsLicencasPie = {
                responsive: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Licenças por tipo',
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
            const configLicencasPie = {
                type: 'pie',
                data: dataLicencasPie,
                options: optionsLicencasPie
            };
            const myChartLicencasPie = new Chart(
                document.getElementById('licencasChart'),
                configLicencasPie
            );
        </script>
    @endpush
    @endsection
</x-app-layout>

