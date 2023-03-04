<x-admin-layout>

    @push('css')
        <!--Insertamos css para select 2-->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <form action="{{ route('admin.post.update', $post) }}" method="Post">
        @csrf
        @method('PUT')

        <div class=" bg-white rounded-lg p-6 shadow-lg">
            <x-jet-validation-errors class=" mb-4" />

            <div class=" mb-4">
                <x-jet-label for="title">
                    Titulo
                </x-jet-label>

                <x-jet-input class=" w-full" name="title" value="{{ old('title', $post->title) }}" id="title"
                    type="text" placeholder="Escribe un titulo" onkeyup="string_to_slug()"
                    onclick="string_to_slug()">

                </x-jet-input>
            </div>

            <div class=" mb-4">
                <x-jet-label for="slug">
                    Slug
                </x-jet-label>

                <x-jet-input class=" w-full" name="slug" value="{{ old('slug', $post->slug) }}" id="slug"
                    type="text">
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
                        <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class=" mb-4">

                <x-jet-label>
                    Etiquetas
                </x-jet-label>

                <select class="js-example-basic-multiple w-full" name="tags[]" multiple="multiple">
                 
                    @foreach ($post->tags as $tag)
                        <option value="{{$tag->name}}" selected>{{$tag->name}}</option>
                    @endforeach
               
                </select>
            </div>

            <div class=" mb-4">
                <x-jet-label for="summary">
                    Resumen
                </x-jet-label>

                <textarea
                    class=" border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                    name="summary" id="summary" rows="3">{{ old('summary', $post->summary) }}
            </textarea>

            </div>


            <div class=" mb-4">
                <x-jet-label for="editor">
                    Contenido
                </x-jet-label>
                <textarea id="editor" name="content">{{ old('content', $post->content) }}</textarea>
            </div>

            <input type="hidden" name="is_published" value="0">
            <div class=" mb-4">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published)==1)  class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-700">Publicar Post</span>
                </label>
            </div>

            <div class=" mb-4">

                <div class=" flex justify-end">
                    <x-jet-button>
                        Actualizar Post
                    </x-jet-button>
                </div>
            </div>
        </div>
    </form>

    @push('js')
        <!--Insertamos cdn de jquery, necesario para que funcione select2-->
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

        <!--insertamos script para select2-->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!--insertamos el cdn de CKEditor5-->
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

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

            //Insertamos el codigo para usar CKEditor 5

            ClassicEditor
                .create(document.querySelector('#editor'))
                .catch(error => {
                    console.error(error);
                });

            //Codigo para ejecutar select2
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2({
                    tags: true, //con esto doy permiso de colocarvalores que no esten en la base de datos
                    tokenSeparators: [',',' '],//es el separador para que ya no busque mas y agregue ducha palabra
                    ajax: {
                        url:"{{route('tags.select2')}}",
                        dataType:'json',
                        delay: 250,
                        data: function(params){
                            return{
                                term: params.term
                            }
                        },
                        processResults:function(data){
                            return{
                                results: data
                            }
                        },
                    }
                });
            });
        </script>
    @endpush

</x-admin-layout>
