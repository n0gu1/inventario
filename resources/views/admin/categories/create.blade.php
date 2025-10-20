<x-admin-layout 
    title="Categorias"
    :breadcrumbs="[
        [
            'name' => '',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Categorias',
            'href' => route('admin.categories.index'),
        ],
        [
            'name' => 'Nuevo',
        ]
    ]"
>
            <x-wire-card>
                <form action="{{route('admin.categories.store')}}" method='POST' class="space-y-4">
                    @csrf

                   <x-wire-input label="Nombre" name='name' placeholder='Nombre de la categoria' value="{{old('name')}}"/> 

                   <x-wire-textarea label="Descripcion" name='description' placeholder='Descripcion de la categoria' value="{{old('name')}}">

                   </x-wire-textarea> 

                   <div class="flex justify-end">
                    <x-button>
                        Guardar
                    </x-button>
                   </div>


                </form>
            </x-wire-card>


</x-admin-layout>
