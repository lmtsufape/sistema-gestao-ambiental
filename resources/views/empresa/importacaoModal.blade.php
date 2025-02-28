<div class="modal fade" id="xmlModal" tabindex="1" aria-labelledby="xmlModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg vh-75">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-3" id="xmlModalLabel">Importar Dados da Empresa</h1>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('empresas.import')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="empresa_xml" class="form-label">Insira um arquivo XML para importar os dados da empresa</label>
                        <input type="file" class="" name="empresa_xml" id="empres_xml" accept=".xml">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success">Importar</button>
                </div>
            </form>
        </div>
    </div>
</div>


