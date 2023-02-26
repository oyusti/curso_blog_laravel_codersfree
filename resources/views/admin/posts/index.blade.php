<x-admin-layout>

    <div class=" flex justify-end mb-6">
        <a href="{{ route('admin.post.create') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Nuevo
        </a>
    </div>

    <ul class=" space-y-8">

        @foreach ($posts as $post)
            <li class=" grid grid-cols-1 md:grid-cols-2 gap-8">

                <figure>
                    <a href="{{ route('admin.post.show', $post) }}"><img
                            class=" aspect-video object-cover object-center w-full" src="{{ $post->image }}"
                            alt="{{ $post->title }}">
                    </a>
                </figure>
                <div>
                    <h1 class=" text-2xl font-semibold">
                        <a href="{{ route('admin.post.show', $post) }}">{{ $post->title }}</a>
                    </h1>
                    <span @class([
                        'bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300' =>
                            $post->is_published,
                        'bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300' => !$post->is_published,
                    ])>
                        {{ $post->is_published ? 'Publicado' : 'No publicado' }}
                    </span>

                    <p class=" mt-4 mb-8">{{ Str::limit($post->summary, 100, '...') }}</p>

                    <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
                        href="{{ route('admin.post.edit', $post) }}">Editar</a>
                </div>

            </li>
        @endforeach

    </ul>

    <div class=" mt-4">
        {{ $posts->links() }}
    </div>
</x-admin-layout>
