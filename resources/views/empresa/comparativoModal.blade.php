<style>
    .sobre{
        box-shadow: 0 0 6px 3px rgba(0, 180, 80, 0.7);
        transition: box-shadow 0.3s ease-in-out;

    }

    .clicado {
        border: 2px solid rgba(0, 136, 61, 0.6);
        box-shadow: 0 2px 8px rgba(0, 136, 61, 0.3);
        border-radius: 0.5rem;
        transition: all 0.3s ease;

    }
</style>
<div class="modal fade" id="comparativoModal" tabindex="1" aria-labelledby="comparativoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg vh-75">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-3" id="comparativoModalLabel">Importar Dados da Empresa</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="comparativo" action="{{route('empresas.comparativo', ['empresa_id' => $empresa_existente->id ?? ''])}}" method="post">
                    @csrf
                    @method('PUT')
                    <h3 class="text-center">Comparação de Dados</h3>
                    <p class="text-center mb-4">Revise as informações e defina o valor que deseja manter.</p>

                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <h5 class="text-center">{{ __('Razão social/Nome') }}</h5>
                        </div>
                        <div class="row card-body">
                            <div class="col-md-6 form-group py-2 rounded py-2 rounded">
                                <label for="">Empresa existente</label>
                                <input id="nome_empresa_existente" class="form-control" type="text" name="nome_empresa_existente"
                                    value="{{ $empresa_existente->nome ?? '' }}" required autofocus
                                    autocomplete="nome_empresa_existente">
                            </div>
                            <div class="col-md-6 form-group py-2 rounded">
                                <label for="">Empresa pelo REDSIM</label>
                                <input id="nome_empresa_upload" class="form-control" type="text" name="nome_empresa_upload"
                                    value="{{ $empresa_upload->nome ?? '' }}" required autofocus
                                    autocomplete="nome_empresa_upload">
                            </div>
                            <input type="hidden" name="nome_escolhido" id="nome_escolhido" value="{{$empresa_existente->nome ?? ''}}">

                        </div>
                    </div>
                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <h5 class="text-center">{{ __('CNPJ') }}</h5>
                        </div>
                        <div class="row card-body">
                            <div class="col-md-6 form-group py-2 rounded" id="div-cnpj">
                                <label for="">Empresa existente</label>

                                <input id="cnpj_empresa_existente" class="form-control" type="text" name="cnpj_empresa_existente"
                                    value="{{ old('cnpj_empresa_existente') ?? ($empresa_existente->cpf_cnpj ?? '') }}" autocomplete="cnpj_empresa_existente">
                            </div>
                            <div class="col-md-6 form-group py-2 rounded" id="div-cnpj">
                                <label for="">Empresa pelo REDSIM</label>

                                <input id="cnpj_empresa_upload" class="form-control" type="text" name="cnpj_empresa_upload"
                                    value="{{ old('cnpj_empresa_upload') ?? ($empresa_upload->cnpj ?? '') }}" autocomplete="cnpj_empresa_upload">
                            </div>
                            <input type="hidden" name="cnpj_escolhido" id="cnpj_escolhido" value="{{$empresa_existente->cpf_cnpj ?? ''}}">

                        </div>
                    </div>
                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <h5 class="text-center">{{ __('Contato') }}</h5>
                        </div>
                        <div class="row card-body">
                            <div class="col-md-6 form-group py-2 rounded">
                                <label for="">Empresa existente</label>

                                <input id="telefone_empresa_existente" class="form-control celular" type="text"
                                    name="telefone_empresa_existente"
                                    value="{{ old('telefone_empresa_existente') ?? ($empresa_existente->telefone->numero ?? '') }}"
                                    required autocomplete="telefone_empresa_existente">
                            </div>
                            <div class="col-md-6 form-group py-2 rounded">
                                <label for="">Empresa pelo REDSIM</label>

                                <input id="telefone_empresa_upload" class="form-control celular" type="text"
                                    name="telefone_empresa_upload"
                                    value="{{ old('telefone_empresa_upload') ?? ($empresa_upload->contato ?? '') }}" required
                                    autocomplete="telefone_empresa_upload">
                            </div>
                            <input type="hidden" name="telefone_escolhido" id="telefone_escolhido" value="{{$empresa_existente->telefone->numero ?? ''}}">

                        </div>
                    </div>

                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <h5 class="text-center">{{ __('CEP') }}</h5>
                        </div>
                        <div class="row card-body">
                            <div class="col-md-6 form-group py-2 rounded">
                                <label for="">Empresa existente</label>

                                <input id="cep_empresa_existente" class="form-control cep " type="text"
                                    name="cep_empresa_existente"
                                    value="{{ old('cep_empresa_existente') ?? ($empresa_existente->endereco->cep ?? '') }}"
                                    required autofocus autocomplete="cep_empresa_existente">
                            </div>
                            <div class="col-md-6 form-group py-2 rounded">
                                <label for="">Empresa pelo REDSIM</label>

                                <input id="cep_empresa_update" class="form-control cep " type="text"
                                    name="cep_empresa_update"
                                    value="{{ old('cep_empresa_update') ?? ($empresa_upload->cep ?? '') }}" required
                                    autofocus autocomplete="cep_empresa_update">
                            </div>
                            <input type="hidden" name="cep_escolhido" id="cep_escolhido" value="{{$empresa_existente->endereco->cep ?? ''}}">
                        </div>
                    </div>
                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <h5 class="text-center">{{ __('Bairro') }}</h5>
                        </div>
                        <div class="row card-body">
                            <div class="col-md-6 form-group py-2 rounded">
                                <label for="">Empresa existente</label>

                                <input id="bairro_empresa_existente" class="form-control" type="text"
                                    name="bairro_empresa_existente"
                                    value="{{ $empresa_existente->endereco->bairro ?? old('bairro_empresa_existente') }}"
                                        required autofocus autocomplete="bairro_empresa_existente">
                            </div>
                            <div class="col-md-6 form-group py-2 rounded">
                                <label for="">Empresa pelo REDSIM</label>

                                <input id="bairro_empresa_update" class="form-control" type="text"
                                    name="bairro_empresa_update"
                                    value="{{ old('bairro_empresa_update', $empresa_upload->bairro ?? '')}}"
                                    required autofocus autocomplete="bairro_empresa_update">
                            </div>
                            <input type="hidden" name="bairro_escolhido" id="bairro_escolhido" value="{{$empresa_existente->endereco->bairro ?? ''}}">

                        </div>
                    </div>
                    <div class="card mb-4 shadow">
                        <div class="card-header">
                            <h5 class="text-center">{{ __('Endereço') }}</h5>
                        </div>
                        <div class="row card-body">
                            <div class="col-md-6">
                                <h5 class="text-center">Empresa existente</h5>
                                <div class="row form-group py-2 rounded">
                                    <div class="col-md-8">
                                        <label for="logradouro_empresa_existente">{!! __('Logradouro <small>(Rua, Avenida...)</small>') !!}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="logradouro_empresa_existente" class="form-control" type="text" name="logradouro_empresa_existente"
                                            value="{{ $empresa_existente->endereco->rua ?? old('logradouro_empresa_existente') }}" required
                                            autocomplete="logradouro_empresa_existente">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="numero_empresa_existente">{{ __('Número') }}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="numero_empresa_existente" class="form-control" type="text"
                                            name="numero_empresa_existente"
                                            value="{{ $empresa_existente->endereco->numero ?? old('numero_empresa_existente') }}"
                                            required autocomplete="numero_empresa_existente">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="text-center">Empresa pelo REDSIM</h5>
                                <div class="row form-group py-2 rounded">
                                    <div class="col-md-8">
                                        <label for="logradouro_empresa_update">{!! __('Logradouro <small>(Rua, Avenida...)</small>') !!}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="logradouro_empresa_update" class="form-control" type="text" name="logradouro_empresa_update"
                                            value="{{ $empresa_upload->logradouro ?? old('logradouro_empresa_update') }}" required
                                            autocomplete="logradouro_empresa_update">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="numero_empresa_update">{{ __('Número') }}<span
                                                style="color: red; font-weight: bold;">*</span></label>
                                        <input id="numero_empresa_update" class="form-control" type="text"
                                            name="numero_empresa_update"
                                            value="{{ $empresa_upload->numero ?? old('numero_empresa_update') }}" required
                                            autocomplete="numero_empresa_update">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="logradouro_escolhido" id="logradouro_escolhido" value="{{$empresa_existente->endereco->rua ?? ''}}">
                            <input type="hidden" name="numero_escolhido" id="numero_escolhido" value="{{$empresa_existente->endereco->numero ?? ''}}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="comparativo" class="btn btn-success">Importar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            if (@json(session('comparativo', false))) {
                $('#comparativoModal').modal('show');
                $('#comparativoModal').find('input, select, textarea').prop('readonly', true);

                $('#comparativo .card-body .form-group').hover(
                    function() {
                        $(this).addClass('sobre');

                    },
                    function() {
                        $(this).removeClass('sobre');
                    })

                $('#comparativo .card-body .form-group').on('click', function(){

                    $(this).closest('.card-body').find('.form-group').removeClass('clicado');
                    $(this).addClass('clicado');

                    if($(this).find('[id*="logradouro_empresa"]').length){
                        $('#logradouro_escolhido').val($(this).find('input').eq(0).val())
                        $('#numero_escolhido').val($(this).find('input').eq(1).val())

                    }else{
                        $(this).closest('.card-body').find('input[type="hidden"]').val($(this).find('input').val())
                    }

                })

                let campos = $('#comparativo .card-body .form-group').find('input, select, textarea')
                for (i = 0; i < campos.length; i += 2) {
                    let card = $(campos[i]).closest('.card');

                    if($(campos[i]).attr('id') == 'logradouro_empresa_existente'){
                        if($(campos[i]).val() != $(campos[i+2]).val()){
                            $(campos[i + 2]).addClass('border-warning')
                            card.removeClass('d-none')
                        }
                    }
                    if($(campos[i + 1]).attr('id') == 'numero_empresa_existente'){
                        if($(campos[i+1]).val() != $(campos[i+3]).val()){
                            console.log('entrou?')
                            $(campos[i + 2]).addClass('border-warning')
                            card.removeClass('d-none')
                            break
                        }else{
                            card.addClass('d-none')
                            break
                        }
                    }

                    if ($(campos[i]).val() != $(campos[i + 1]).val()) {
                        $(campos[i + 1]).addClass('border-warning')
                        card.removeClass('d-none')
                    }else{
                        card.addClass('d-none')
                    }

                }
            }

        })
    </script>
@endpush