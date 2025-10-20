<div class="flex items-center space-x-2">

    @can('update-customers')
    <x-wire-button href="{{route('admin.customers.edit', $customer)}}" blue xs>
        Editar
    </x-wire-button>
    @endcan

    @can('delete-customers')
    <form action="{{ route('admin.customers.destroy', $customer) }}"
        method='POST'
        class="delete-form">

        @csrf
        @method('DELETE')

        <x-wire-button type="submit" red xs>
            Eliminar
        </x-wire-button>

    </form>
    @endcan

</div>