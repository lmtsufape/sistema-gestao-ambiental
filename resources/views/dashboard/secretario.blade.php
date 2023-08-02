<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row">
            <div class="col-md-12">
                <h4 class="card-title">Dashboard estatístico</h4>
            </div>
        </div>
        <div class="d-flex">
            <div class="ps-1 mt-0 pt-0" style="font-size: 14px; color: black;">
                <span style="font-weight: bolder;">Apuração rápida nos
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
                        <a class="dropdown-item" href="{{route('dashboard', ['ordenacao' => '7_dias'])}}"></a>
                    </div>
                    <div class="form-check link-ordenacao">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" @if($ordenacao == 'ultimo_mes') checked @endif>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Últimos 30 dias
                        </label>
                        <a class="dropdown-item" href="{{route('dashboard', ['ordenacao' => 'ultimo_mes'])}}"></a>
                    </div>
                    <div class="form-check link-ordenacao">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" @if($ordenacao == 'meses') checked @endif>
                        <label class="form-check-label" for="flexRadioDefault3">
                            Últimos 12 meses
                        </label>
                        <a class="dropdown-item" href="{{route('dashboard', ['ordenacao' => 'meses'])}}"></a>
                    </div>
                    <div class="form-check link-ordenacao">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4" @if($ordenacao == 'anos') checked @endif>
                        <label class="form-check-label" for="flexRadioDefault4">
                            Últimos 5 anos
                        </label>
                        <a class="dropdown-item" href="{{route('dashboard', ['ordenacao' => 'anos'])}}"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="shadow-sm p-2 px-3" style="background-color: #ffffff; border-radius: 00.5rem; width: 100%">
            <div style="font-size: 21px; margin-bottom: 10px;" class="tituloModal">
                Filtrar por período
            </div>
            <!-- AQUI QUE ROTA -->
            <form id="form-fitrar-boleto" method="GET" action="{{route('dashboard')}}"> 
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
                        <button type="submit" id="submeterFormBotao" class="btn btn-success btn-color-dafault submeterFormBotao" form="form-fitrar-boleto" style="width: 80%">Filtrar</button>
                    </div>
                </div>
                <div style="border-bottom:solid 3px #e0e0e0; margin-top: -1%; margin-bottom: 3%;">
                </div>
            </form>
        </div>
        <div class="text-center">
            <div class="row align-items-center">
                <div class="col-md-6">
                    @if ($data->count() > 0)
                        <canvas id="requerimentosChart"></canvas>
                        <p>Totalizando {{array_sum(array_values($data->toArray()))}} requerimentos criados</p>
                    @else
                        <p>Nenhum requerimento criado no período informado</p>
                    @endif
                </div>
                <div class="col-md-6">
                    @if ($licencasData->count() > 0)
                        <canvas id="licencasChart"></canvas>
                        <p>Totalizando {{array_sum(array_values($licencasData->toArray()))}} licenças emitidas</p>
                    @else
                        <p>Nenhuma licença gerada no período informado</p>
                    @endif
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6">
                    @if ($mudasData->count() > 0)
                        <canvas id="mudasChart"></canvas>
                        <p>Totalizando {{array_sum(array_values($mudasData->toArray()))}} mudas solicitadas</p>
                    @else
                        <p>Nenhuma solicitação de muda criada no período informado</p>
                    @endif
                </div>
                <div class="col-md-6">
                    @if ($podasData->count() > 0)
                        <canvas id="podasChart"></canvas>
                        <p>Totalizando {{array_sum(array_values($podasData->toArray()))}} solicitações de poda/supressão solicitadas</p>
                    @else
                        <p>Nenhuma solicitação de poda/supressão criada no período informado</p>
                    @endif
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-6">
                    @if (count($boletoData) > 0)
                        <canvas id="pagamentosPie"></canvas>
                        <p>Totalizando {{array_sum(array_values($boletoData))}} boletos gerados</p>
                    @else
                        <p>Nenhum boleto gerado no período informado</p>
                    @endif
                </div>
                <div class="col-md-6">
                    @if ($denunciasData->count() > 0)
                        <canvas id="denunciasChart"></canvas>
                        <p>Totalizando {{array_sum(array_values($denunciasData->toArray()))}} denúncias registradas</p>
                    @else
                        <p>Nenhuma denúncia registrada no período informado</p>
                    @endif
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 20px; margin-bottom: 20px;">
                @if ($notificacoes->count() > 0)
                    <h2 style="text-align: center; font-size: 16px; color: #273746;">
                        Quantidade de notificações realizadas no período informado: <span style="font-size: 18px; font-weight: bold;">{{ $notificacoes->count() }}</span>
                    </h2>
                @else
                    <h2 style="text-align: center; font-size: 16px; color: #273746;">Nenhuma notificação realizada no período informado</h2>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <canvas id="pagamentosChart"></canvas>
                </div>
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
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Requerimentos de licença por status',
                        font: {
                            size: 16
                        }
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
                            font: {
                                size: 16
                            }
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
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Boletos por status',
                        font: {
                            size: 16
                        }
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
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Solicitações de mudas por status',
                        font: {
                            size: 16
                        }
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
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Solicitações de podas por status',
                        font: {
                            size: 16
                        }
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
                const dataDenunciasPie = {
                    labels: Object.keys(dadosDenunciasPie),
                    datasets: [{
                        data: Object.values(dadosDenunciasPie),
                        backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                        hoverOffset: 0,
                    }]
                };
                const optionsDenunciasPie = {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Registros de denúncias por status',
                            font: {
                                size: 16
                            }
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
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Licenças por tipo',
                        font: {
                            size: 16
                        }
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

