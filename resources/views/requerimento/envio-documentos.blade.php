<x-app-layout>
    @section('content')

    @livewire('enviar-documentos', ['requerimento' => $requerimento])

    @push ('scripts')
        <script>
            function editar_caminho(string) {
                return string.split("\\")[string.split("\\").length - 1];
            }
            function checar_arquivos() {
                $("#modalStaticConfirmarEnvio").modal('show');
            }
        </script>
    @endpush
    @endsection
</x-app-layout>
