<x-admin-layout
    title="Roles"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Roles',
        ]
    ]">

    @can('create-roles')
    <x-slot name="action">
        <x-wire-button href="{{route('admin.roles.create')}}" blue>
            Nuevo
        </x-wire-button>
    </x-slot>
    @endcan

    <h1 class="text-xl font-bold mb-4">Gestión de Roles</h1>

    @livewire('admin.datatables.role-table')

</x-admin-layout>