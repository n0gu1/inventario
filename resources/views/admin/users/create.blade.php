{{-- resources/views/admin/users/create.blade.php --}}
<x-admin-layout
    title="Usuarios"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Usuarios',
            'href' => route('admin.users.index'),
        ],
        [
            'name' => 'Crear Usuario',
        ]
    ]">

    <x-wire-card>
        <h1 class="text-2xl font-semibold mb-4">Nuevo Usuario</h1>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <x-wire-input
                    label="Nombre"
                    name="name"
                    required
                    placeholder="Nombre del usuario"
                    value="{{ old('name') }}" />

                <x-wire-input
                    label="Correo Electrónico"
                    name="email"
                    required
                    placeholder="Correo electrónico del usuario"
                    value="{{ old('email') }}" />

                <x-wire-input
                    label="Contraseña"
                    name="password"
                    required
                    placeholder="Contraseña del usuario"
                    type="password" />

                <x-wire-input
                    label="Confirmar Contraseña"
                    name="password_confirmation"
                    required
                    placeholder="Confirmar contraseña del usuario"
                    type="password" />
            </div>

            {{-- Bloque NUEVO: asignación de Roles --}}
            <div class="mt-6">
                <p class="block text-sm font-medium disabled:opacity-60 text-gray-600 mb-2">
                    Roles
                </p>

                <ul class="columns-1 md:columns-2 lg:columns-4 gap-4">
                    @foreach ($roles as $role)
                        <li>
                            <label class="inline-flex items-center space-x-2">
                                <x-checkbox
                                    name="roles[]"
                                    value="{{ $role->id }}"
                                    :checked="in_array($role->id, old('roles', []))" />
                                <span class="text-sm text-gray-700 dark:text-gray-400">
                                    {{ $role->name }}
                                </span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end mt-6">
                <x-wire-button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700">
                    Crear Usuario
                </x-wire-button>
            </div>
        </form>
    </x-wire-card>

</x-admin-layout>
