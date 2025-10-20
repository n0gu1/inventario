<div class="flex items-center space-x-2">

    @can( 'update-suppliers')
    <x-wire-button href="{{route('admin.suppliers.edit', $supplier)}}" blue xs>
        Editar
    </x-wire-button>

    @can( 'delete-suppliers')
    <form action="{{ route('admin.suppliers.destroy', $supplier) }}"
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