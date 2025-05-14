<div class="modal fade" id="xmlModal" tabindex="1" aria-labelledby="xmlModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg vh-75">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-3" id="xmlModalLabel">Importar Dados da Empresa</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mx-4 mt-5">
                <form id="form-importar-empresa" action="{{ route('empresas.import') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" class="custom-file-input" name="empresa_xml" id="empresa_xml"
                            accept=".xml">
                        <label for="empresa_xml" class="custom-file-label">Insira um arquivo XML para importar os dados
                            da empresa</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" form="form-importar-empresa" class="btn btn-success">Importar</button>
            </div>
        </div>
    </div>
</div>