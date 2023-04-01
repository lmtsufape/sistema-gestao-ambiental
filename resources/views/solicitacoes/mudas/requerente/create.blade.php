<x-app-layout>
    @section('content')
    <div class="container-fluid" style="padding-top: 3rem; padding-bottom: 6rem; padding-left: 10px; padding-right: 20px">
        <div class="form-row justify-content-center">
            <div class="col-md-12">
                <div class="form-row">
                    <div class="col-md-8">
                        <h4 class="card-title">Realizar solicitação de mudas</h4>
                    </div>
                    <div class="col-md-4" style="text-align: right; padding-top: 15px;">
                        {{-- <a title="Voltar" href="{{route('mudas.requerente.index')}}">
                            <img class="icon-licenciamento btn-voltar" src="{{asset('img/back-svgrepo-com.svg')}}" alt="Icone de voltar">
                        </a> --}}
                        <a class="btn btn-success btn-color-dafault" data-toggle="modal"
                            data-target="#modalAcompanharSolicitacao">Acompanhar solicitação</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div div class="form-row">
                            @if (session('success'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-success" role="alert">
                                        <p>{{ session('success') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="col-md-12" style="margin-top: 5px;">
                                    <div class="alert alert-danger" role="alert">
                                        <p>{{ session('error') }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (session('success'))
                                @push ('scripts')
                                    <script>
                                        $(function() {
                                            jQuery.noConflict();
                                            $('#modalProtocolo').modal('show');
                                        });
                                    </script>
                                @endpush
                            @endif
                        </div>
                        
                        <form method="POST" id="cria-solicitacao" action="{{ route('mudas.store') }}">
                            @csrf
                            <div class="form-row justify-content-between">
                                <div class="col-md-8">
                                    <div class="card card-borda-esquerda" style="width: 100%;">
                                        <div class="card-body">
                                            <table class="table" data-toggle="table" id="especies">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Espécie<span style="color: red; font-weight: bold;">*</span></th>
                                                        <th scope="col">Quantidade<span style="color: red; font-weight: bold;">*</span></th>
                                                        <th scope="col"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select required class="form-control @error('especie.*') is-invalid @enderror" name="especie[]">
                                                                <option value="" disabled selected>-- Selecionar a espécie--</option>
                                                                @foreach ($especies as $especie)
                                                                    <option value={{$especie->id}}>{{$especie->nome}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('especie.*')
                                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input id="qtd_mudas-1" class="form-control @error('qtd_mudas.*') is-invalid @enderror"
                                                                type="number" min="1" name="qtd_mudas[]" value="{{ old('qtd_mudas.*') }}"
                                                                autocomplete="qtd_mudas" required>
                                                            @error('qtd_mudas.*')
                                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="form-row mb-2 justify-content-between">
                                                <div class="col-md-12" style="text-align: right">
                                                    <input type="hidden" id="especie_indice" value="-1">
                                                        Adicionar nova espécie a este solicitação
                                                    <a title="Adicionar nova espécie" id="btn-add-especie" onclick="addEspecie()" style="cursor: pointer;">
                                                        <img class="icon-licenciamento " src="{{asset('img/Grupo 1666.svg')}}" style="height: 35px" alt="Icone de adicionar nova espécie">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-row mb-2">
                                        <label for="local">Endereço completo do local de plantio<span style="font-weight: bold; color: red">*</span><span style="font-weight: normal; color: rgb(88, 88, 88)">(Informar o endereço completo do local onde as mudas serão plantadas)</span></label>
                                        <textarea id="local" class="form-control @error('local') is-invalid @enderror"
                                                  name="local"
                                                  autocomplete="local" rows="3" required>{{old('local')}}</textarea>
                                        @error('local')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-row">
                                        <label for="comentario">Comentário <span style="font-weight: normal; color: rgb(88, 88, 88)">(Mencionar informação que julgar necessária)</span></label>
                                        <textarea id="comentario" class="form-control @error('comentario') is-invalid @enderror"
                                                  name="comentario"
                                                  autocomplete="comentario" rows="3">{{old('comentario')}}</textarea>
                                        @error('comentario')
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="col-md-6 form-group"></div>
                                <div class="col-md-6 form-group">
                                    <button type="submit" class="btn btn-success submeterFormBotao btn-color-dafault" style="width: 100%;">Confirmar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalProtocolo" role="dialog" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #dcd935;">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: rgb(66, 66, 66);">Protocolo da
                        solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="word-break: break-all">
                    Anote o seguinte protocolo para acompanhar o status da solicitação
                    <br>
                    Protocolo:
                    <strong>{{ session('protocolo') }}</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal acompanhar solicitacao -->
    <div class="modal fade" id="modalAcompanharSolicitacao" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--primaria);">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Acompanhe o status da sua
                        solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="status-solicitacao" method="GET" action="{{ route('mudas.status') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 form-group">
                                <label for="protocolo">{{ __('Protocolo') }}<span style="color: red; font-weight: bold;">*</span></label>
                                <input id="protocolo" class="form-control @error('protocolo') is-invalid @enderror"
                                    type="text" name="protocolo" value="{{ old('protocolo') }}" required autofocus
                                    autocomplete="protocolo">
                                @error('protocolo')
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="submeterFormBotao btn btn-success btn-color-dafault" form="status-solicitacao">Ir</button>
                </div>
            </div>
        </div>
    </div>
    @push ('scripts')
        <script>
            function addEspecie() {
                var indice = document.getElementById("especie_indice");
                var especie_indice = parseInt(document.getElementById("especie_indice").value)+1;
                indice.value = especie_indice;

                var campo_especie = `<tr>
                                        <td>
                                            <select required class="form-control @error('especie.*') is-invalid @enderror" name="especie[]">
                                                <option value="" disabled selected>-- Selecionar a espécie--</option>
                                                @foreach ($especies as $especie)
                                                    <option value={{$especie->id}}>{{$especie->nome}}</option>
                                                @endforeach
                                            </select>
                                            @error('especie.*')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <input id="qtd_mudas`+especie_indice+`" class="form-control @error('qtd_mudas.*') is-invalid @enderror"
                                                type="number" min="1" name="qtd_mudas[]" value="{{ old('qtd_mudas.*') }}"
                                                autocomplete="qtd_mudas" required>
                                            @error('qtd_mudas.*')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </td>
                                        <td>
                                            <div>
                                                <a style="cursor: pointer; color: #ec3b3b; font-weight: bold;" onclick="this.parentElement.parentElement.parentElement.remove()">remover</a>
                                            </div>
                                        </td>
                                    </tr>`;

                $('#especies tbody').append(campo_especie);
            }
        </script>
    @endpush
@endsection
</x-app-layout>
