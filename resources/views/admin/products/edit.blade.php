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
            'name' => 'Editar',
        ],
    ]">

    @push('css')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    @endpush

    <form action="{{route('admin.products.dropzone', $product)}}" method="POST" class="dropzone" id="myDropzone">
        @csrf
    </form>

    <x-wire-card>
        <form action="{{route('admin.products.update', $product)}}" method='POST' class="space-y-4">
            @csrf
            @method('PUT')

            <x-wire-input label="Nombre" name='name' placeholder='Nombre de la categoria' value="{{old('name', $product->name)}}" />

            <x-wire-textarea label="Descripcion" name='description' placeholder='Descripcion de la categoria' value="{{old('name', $product->description)}}">

            </x-wire-textarea>

            <x-wire-input type="number" label="Precio" name='price' placeholder='Precio del producto' value="{{old('price', $product->price)}}" />

            <x-wire-native-select label="Categoria" name='category_id'>
                @foreach ($categories as $category)
                <option value="{{$category->id}}" @selected(old('category_id', $product->category_id)==$category->id)>
                    {{$category->name}}
                </option>
                @endforeach
            </x-wire-native-select>

            <div class="flex justify-end">
                <x-button>
                    Actualizar
                </x-button>
            </div>


        </form>
    </x-wire-card>

    @push('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <script>
        Dropzone.options.myDropzone = {

            addRemoveLinks: true,
            init: function() {
                let myDropzone = this;

                // Cargar imágenes existentes desde el servidor
                let images = @json($product->images);

                images.forEach(function(image) {
                    let mockFile = {
                        id: image.id,
                        name: image.path.split('/').pop(),
                        size: image.size,
                    };

                    myDropzone.displayExistingFile(mockFile, `{{ Storage::url('${image.path}') }}`);
                    myDropzone.displayExistingFile(mockFile, `{{ Storage::disk('public')->url('${image.path}') }}`);
                    myDropzone.emit("complete", mockFile);
                    myDropzone.files.push(mockFile);
                });

                this.on("success", function(file, response) {
                    file.id = response.id; // Asignar el ID de la imagen al archivo
                });

                this.on("removedfile", function(file) {

                    axios.delete(`/admin/images/${file.id}`)
                        .then(response => {
                            console.log(response.data);
                        })
                        .catch(error => {
                            console.error(error);
                        });

                });
            }

        };
    </script>
    @endpush

</x-admin-layout>