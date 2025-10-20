<x-admin-layout
    title="Clientes"
    :breadcrumbs="[
        [
            'name' => '',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Clientes',
            'href' => route('admin.customers.index'),
        ],
        [
            'name' => 'Nuevo',
        ]
    ]">
    <x-wire-card>
        <form action="{{route('admin.customers.store')}}" method='POST' class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                {{-- Deben ir como ATRIBUTOS del tag de apertura --}}
                <x-wire-native-select label="Tipo de documento" name="identity_id">
                    <option value="">Seleccione…</option>
                    @foreach ($identities as $identity)
                    <option value="{{ $identity->id }}" @selected(old('identity_id')==$identity->id)>
                        {{ $identity->name }}
                    </option>
                    @endforeach
                </x-wire-native-select>

                <x-wire-input
                    label="Numero de documento"
                    name="document_number"
                    placeholder="Numero de documento"
                    value="{{ old('document_number') }}"
                    required />
            </div>

            <x-wire-input label="Nombre" name="name" placeholder="Nombre del cliente" value="{{ old('name') }}" required />
            <x-wire-input label="Direccion" name="address" placeholder="Direccion del cliente" value="{{ old('address') }}" />
            <x-wire-input label="Correo electronico" name="email" type="email" placeholder="Correo electronico del cliente" value="{{ old('email') }}" />
            <x-wire-input label="Telefono" name="phone" placeholder="Telefono del cliente" value="{{ old('phone') }}" />

            <div class="flex justify-end">
                <x-button type="submit">
                    Guardar
                </x-button>
            </div>



        </form>
    </x-wire-card>


</x-admin-layout>