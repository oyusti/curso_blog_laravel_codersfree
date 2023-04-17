<x-app-layout>

    <figure class=" mb-12">
        <img src="{{ asset('img/Home/php.jpg') }}" alt="Portada de Home"
            class="w-full aspect-[3/1] object-cover object-center">
    </figure>

    <section class=" max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <h1 class=" text-3xl text-center font-semibold mb-6">
            Lista de Posts
        </h1>

        <div class=" grid grid-cols-4">

            <div class=" col-span-1">

                <form action="">

                    <div class=" mb-4">
                        <p class=" text-lg font-semibold">Ordenar:</p>

                        <select name="order"
                            class=" border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="new">Más recientes</option>
                            <option value="old" @selected(request('order')=='old')>Más antiguos</option>{{-- Si el valor order es igual a old, entonces me lo deja por defecto marcado --}}
                        </select>

                    </div>

                    <div class=" mb-4">
                        <p class=" text-lg font-semibold">Categorias:</p>

                        <ul>

                            @foreach ($categories as $category)
                                <li>
                                    <label>
                                        {{-- Para dejar seleccionado los checbox pregunto primero si es un array y luego si el valor esta dentro del array --}}
                                        <x-jet-checkbox name="category[]" value="{{ $category->id }}" :checked="is_array(request('category')) && in_array($category->id, request('category'))"/>
                                        <span class=" ml-2 text-gray-700">{{ $category->name }}</span>
                                    </label>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    <x-jet-button>
                        Aplicar Filtros
                    </x-jet-button>    
                </form>

            </div>

            <div class=" col-span-3">
                <div class=" space-y-8">

                    @foreach ($posts as $post)
                        <article class=" grid grid-cols-2 gap-6">

                            <figure>
                                <img src="{{ $post->image }}" alt="{{ $post->title }}" class=" aspect-[3/1]">
                            </figure>

                            <div>
                                <h1>
                                    {{ $post->title }}
                                    <hr class=" mt-1 mb-2">
                                </h1>
                                <div class=" mb-2">
                                    @foreach ($post->tags as $tag)
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                                <p class=" text-sm mb-2">
                                    {{ $post->published_at->format('d M Y') }}{{-- Al hacer esto me dara error porque no le hemos especificado que es una fecha. Eso lo hacemos en el modelo Post al castear la variable --}}
                                </p>
                                <div class=" mb-12">
                                    {{ Str::limit($post->summary, 200) }}{{-- Cuando se pase de los 100 caracteres me colocarapor defecto los tres puntos, si quiero colocar otra cosa coloco como tercer parametro ejemplo '+++' o '***' --}}
                                </div>
                                <div>
                                    <a href="{{ route('posts.show', $post) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Leer más
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>



        <div class=" mt-8">
            {{ $posts->links() }}
        </div>

    </section>

</x-app-layout>
