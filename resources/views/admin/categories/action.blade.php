<div class="flex items-center space-x-2">

    @can('update-categories')
    <x-wire-button href="{{route('admin.categories.edit', $category)}}" blue xs>
        Editar
    </x-wire-button>
    @endcan

    @can('delete-categories')
    <form action="{{ route('admin.categories.destroy', $category) }}"
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