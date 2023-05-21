<x-app-layout>

    <section class=" max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-24 py-12">

        <div class=" mb-2">
            @foreach ($post->tags as $tag)
                <span
                    class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>

        <h1 class=" text-4xl font-semibold mb-2">
            {{$post->title}}
        </h1>

        <hr class=" mt-1 mb-2">

        <p class=" text-sm mb-6">
            {{ $post->published_at->format('d M Y') }} - {{ $post->user->name}}{{-- Al hacer esto me dara error porque no le hemos especificado que es una fecha. Eso lo hacemos en el modelo Post al castear la variable --}}
        </p>

        <figure class=" mb-6">
            <img src="{{ $post->image }}" alt="{{ $post->title }}"
                class=" w-full aspect-[16/9] object-cover object-center">
        </figure>

        <div class=" text-lg mt-4 mb-16">
            {!! $post->content !!} {{-- Con esto le decimos que no lo tome como texto plano, sino que lo tome como html --}}
        </div>

        <div>
            @livewire('question', ['model' => $post])
        </div>




        
    </section>

</x-app-layout>
