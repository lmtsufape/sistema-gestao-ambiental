<x-app-layout>
    @section('content')

    @livewire('enviar-documentos', ['requerimento' => $requerimento])

    @push ('scripts')
        <script>
            window.addEventListener('swal:fire', event => {
                Swal.fire({
                    position: 'bottom-end',
                    icon: event.detail.icon,
                    title: event.detail.title,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 3000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            });
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
