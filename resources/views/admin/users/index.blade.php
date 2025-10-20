<x-admin-layout
    title="Usuarios"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Usuarios'
        ] 
    ]">

    @can('create-users')
    <x-slot name="action">
        <x-wire-button href="{{ route('admin.users.create') }}" blue>
            <i class="fas fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>
    @endcan


    @livewire('admin.datatables.user-table')

</x-admin-layout>