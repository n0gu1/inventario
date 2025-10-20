<x-admin-layout
    title="Compras"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Compras'
        ] 
    ]">

    @can('create-purchases')
    <x-slot name="action">
        <x-wire-button href="{{route('admin.purchases.create')}}" blue>
            Nuevo
        </x-wire-button>
    </x-slot>
    @endcan


    @livewire('admin.datatables.purchase-table')

</x-admin-layout>