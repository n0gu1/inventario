<x-admin-layout
    title="Reportes"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.reports.top-products'),
        ],
        [
            'name' => 'Productos mas vendidos'
        ] 
    ]">

    @livewire('admin.datatables.top-products-table')        

</x-admin-layout>
