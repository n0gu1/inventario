<x-admin-layout
    title="Roles"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Roles',
            'href' => route('admin.roles.index'),
        ],
        [
            'name' => 'Editar'
        ]
    ]">

    <x-wire-card>
        <h1 class="text-2xl font-semibold mb-4">
            Editar Rol
        </h1>
        <form action="{{ route('admin.roles.update', $role) }}"
            method="POST"
            class="space-y-4">
            @csrf
            @method('PUT')

            <x-wire-input
                name="name"
                label="Nombre del Rol"
                placeholder="Ejm: Administrador"
                value="{{ old('name', $role->name) }}"
                required />

            <div>
                <p class="block text-sm font-medium disabled:opacity-60 text-gray-600 mb-2">
                    Permisos
                </p>

                <ul class="columns-1 md:columns-2 lg:columns-4 gap-4">
                    @foreach ($permissions as $permission)
                    <li>
                        <label>
                            <x-checkbox
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                :checked="in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray()))" />

                            <span class="text-sm text-gray-700 dark:text-gray-400">
                                {{ __('permissions.' . $permission->name) ?? $permission->name }}
                            </span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end mt-6">
                <x-wire-button
                    type="submit" blue>
                    Editar Rol
                </x-wire-button>
            </div>

    </x-wire-card>

</x-admin-layout>
