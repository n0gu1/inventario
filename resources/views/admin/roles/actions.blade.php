<div class="flex items-center space-x-2">

    @can('update-roles')
    <x-wire-button href="{{route('admin.roles.edit', $role)}}" blue xs>
        Editar
    </x-wire-button>
    @endcan

    @can('delete-roles')
    <form action="{{ route('admin.roles.destroy', $role) }}"
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