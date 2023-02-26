<x-admin-layout>

    <h1 class=" text-3xl font-semibold mb-2">Nuevo Articulo</h1>

    <form action="{{ route('admin.post.store') }}" method="Post">
        @csrf

        <div class=" bg-white rounded-lg p-6 shadow-lg">
            <x-jet-validation-errors class=" mb-4" />

            <div class=" mb-4">
                <x-jet-label for="title">
                    Titulo
                </x-jet-label>

                <x-jet-input class=" w-full" name="title" value="{{ old('title') }}" id="title" type="text"
                    placeholder="Escribe un titulo" onkeyup="string_to_slug()" onclick="string_to_slug()">

                </x-jet-input>
            </div>

            <div class=" mb-4">
                <x-jet-label for="slug">
                    Slug
                </x-jet-label>

                <x-jet-input class=" w-full" name="slug" value="{{ old('slug') }}" id="slug" type="text"
                    placeholder="Escribe un titulo">

                </x-jet-input>
            </div>

            <div class=" mb-4">

                <x-jet-label for="category">
                    Categoria
                </x-jet-label>

                <select
                    class=" border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                    name="category_id" id="category">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class=" flex justify-end">
                <x-jet-button>
                    Crear Post
                </x-jet-button>
            </div>
        </div>
    </form>

    <script>
        ////esta funcion me crea un slug a traves del string que le pasemos en title
        function string_to_slug() {

            title = document.getElementById("title").value;
            title = title.replace(/^\s+|\s+$/g, '');
            title = title.toLowerCase();
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                title = title.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }
            title = title.replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');

            document.getElementById('slug').value = title;

        }
    </script>

</x-admin-layout>
