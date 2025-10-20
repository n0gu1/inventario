<div class="flex items-center space-x-2">

    @can('update-users')
    <x-wire-button href="{{route('admin.users.edit', $user)}}" blue xs>
        Editar
    </x-wire-button>
    @endcan

    @can('delete-users')
    <form action="{{ route('admin.users.destroy', $user) }}"
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