<x-admin-layout
    title="Proveedores"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Proveedores',
        ] 
    ]">

    @push('css')
    <style>
        table th span,
        table td {
            font-size: 0.75rem !important;
        }
    </style>
    @endpush

    @can('create-suppliers')
    <x-slot name="action">
        <x-wire-button href="{{route('admin.suppliers.create')}}" blue>
            Nuevo
        </x-wire-button>
    </x-slot>
    @endcan

    @livewire('admin.datatables.supplier-table')

    @push('js')
    <script>
        forms = document.querySelectorAll('.delete-form');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "¿Estas Seguro?",
                    text: "No podras revertir esta accion!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    @endpush

</x-admin-layout>