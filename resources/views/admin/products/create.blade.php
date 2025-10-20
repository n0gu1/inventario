<x-admin-layout
    title="Productos"
    :breadcrumbs="[
        [
            'name' => '',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Productos',
            'href' => route('admin.products.index'),
        ],
        [
            'name' => 'Nuevo',
        ]
    ]">
    <x-wire-card>
        <form action="{{route('admin.products.store')}}" method='POST' class="space-y-4">
            @csrf

            <x-wire-input label="Nombre" name='name' placeholder='Nombre de la categoria' value="{{old('name')}}" />

            <x-wire-textarea label="Descripcion" name='description' placeholder='Descripcion de la categoria' value="{{old('name')}}">

            </x-wire-textarea>

            <x-wire-input type="number" label="Precio" name='price' placeholder='Precio del producto' value="{{old('price')}}" />

            <x-wire-native-select label="Categoria" name='category_id'>
                @foreach ($categories as $category)
                <option value="{{$category->id}}" @selected(old('category_id')==$category->id)>
                    {{$category->name}}
                </option>
                @endforeach
            </x-wire-native-select>

            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>


        </form>
    </x-wire-card>


</x-admin-layout>