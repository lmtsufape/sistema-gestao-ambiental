<x-app-layout>
    @section('content')

    @livewire('enviar-documentos', ['requerimento' => $requerimento])

    <script>
        function editar_caminho(string) {
            return string.split("\\")[string.split("\\").length - 1];
        }
        function checar_arquivos() {
            $("#modalStaticConfirmarEnvio").modal('show');
        }
    </script>
    @endsection
</x-app-layout>
