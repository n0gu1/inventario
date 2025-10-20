<x-admin-layout
    title="Clientes"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Clientes',
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

    @can('create-customers')
    <x-slot name="action">
        <x-wire-button href="{{route('admin.customers.create')}}" blue>
            Nuevo
        </x-wire-button>
    </x-slot>
    @endcan

    @livewire('admin.datatables.customer-table')

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