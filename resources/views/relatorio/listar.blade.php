<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-between">
            <div class="col-md-9">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Relatórios</h4>
                    </div>
                </div>

                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="tab-content tab-content-custom" id="myTabContent">
                            <div class="tab-pane fade show active" id="requerimnetos-atuais" role="tabpanel" aria-labelledby="requerimnetos-atuais-tab">
                                <div class="table-responsive">
                                    <table class="table mytable" id="requerimento_table">
                                        <thead>
                                            <tr>
                                                <th>Data de Criação do Relatório</th>
                                                <th>Analista Responsável</th>
                                                <th>Data de Visita</th>
                                                <th>Relatório</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($relatorios as $index => $relatorio)
                                            <tr>
                                                <td class="align-middle">{{ date('d/m/Y', strtotime($relatorio->created_at)) }}</td>
                                                <td>{{ $visitas[$index]->analista->name }}</td>
                                                <td>{{ $visitas[$index]->data_realizada ?? "-" }}</td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('relatorios.show', $relatorio->id) }}" title="Relatório">
                                                        <img class="icon-licenciamento" width="20" src="{{ asset('img/relatorios antigos.svg') }}" alt="Icone de relatório">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endsection
</x-app-layout>