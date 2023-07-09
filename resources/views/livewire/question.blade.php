<div>
    {{-- Este div corresponde  al textarea del comentario y al boton Comentar --}}
    <div class=" flex">
        <figure class=" mr-4">

            <img class="h-12 w-12 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="">

        </figure>
        
        <div class="flex-1">

            <form wire:submit.prevent="store">

                {{-- <textarea wire:model.defer="message" rows="3"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                    placeholder="Escribe tu mensaje"></textarea> --}}

                <x-balloon_editor wire:model="message" />

                <x-jet-input-error for="message" class=" mt-4" />

                <div class=" flex justify-end mt-2">
                    <button class=" bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Comentar
                    </button>
                </div>

            </form>

        </div>
    </div>

    
    <p class=" text-lg font-semibold mt-6 mb-4">
        Comentarios
    </p>

    {{-- Esta seccion corresponde al listado de los comentarios --}}
    <ul class=" space-y-6">

        @foreach ($this->questions as $question)
            <li wire:key="question-{{ $question->id }}">{{-- Con esto Livewire sabe que item tiene que actualizar o eliminar --}}

                {{-- Este div corresponde al listado de los comentarios y sus acciones como editar y eliminar --}}
                <div class=" flex">

                    <figure class=" mr-4">
                        <img src="{{ $question->user->profile_photo_url }}" class="h-12 w-12 rounded-full object-cover">
                    </figure>

                    {{-- Este div corresponde al nombre del usuario, la fecha de creacion del comentario y el comentario --}}
                    <div class="flex-1">
                        <p class=" font-semibold">
                            {{ $question->user->name }}

                            <span class=" text-sm font-normal">
                                {{ $question->created_at->diffForHumans() }}
                            </span>
                        </p>

                        {{-- Si hemos puslsado el boton editar, muestrame el formulario de editar --}}
                        @if ($question->id == $question_edit['id'])
                            <form wire:submit.prevent="update">
                                {{-- <textarea wire:model="question_edit.body" rows="3"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                                    placeholder="Escribe tu mensaje"></textarea> --}}

                                <x-balloon_editor wire:model="question_edit.body" :focus="true"/>


                                <x-jet-input-error for="question_edit.body" class=" mt-1">

                                </x-jet-input-error>

                                <div class=" flex justify-end mt-2">
                                    <x-jet-danger-button class=" mr-2" wire:click="cancel">
                                        Cancelar
                                    </x-jet-danger-button>
                                    <x-jet-button>
                                        Actualizar
                                    </x-jet-button>
                                </div>
                            </form>
                        @else {{-- Sino muestrame el comentario del usuario --}}
                            <p>
                                {!!$question->body!!}{{-- Con el doble ! le estamos diciendo que considere las etiquetas <p> --}}
                            </p>
                        @endif

                    </div>
                    
                    {{-- Este div corresponde a los botones de editar y eliminar del dropdown --}}
                    <div>
                        {{-- debemos definir dos slots, uno para el trigger y otro para el content --}}
                        <x-jet-dropdown>
                            <x-slot name="trigger">{{-- slot para el trigger --}}
                                <button>
                                    <i class=" fas fa-ellipsis-v"></i>
                                </button>
                            </x-slot>

                            <x-slot name="content">{{-- slot para el content --}}
                                {{-- utilizamos otro componente de jetstream para crear los links del dropdown con sus estilos --}}
                                <x-jet-dropdown-link class=" cursor-pointer" wire:click="edit({{ $question->id }})">
                                    {{-- Aqui le pasamos el comentario que queremos editar --}}
                                    Editar
                                </x-jet-dropdown-link>

                                {{-- utilizamos otro componente de jetstream para crear los links del dropdown con sus estilos --}}
                                <x-jet-dropdown-link class=" cursor-pointer" wire:click="destroy({{ $question->id }})">
                                    {{-- Aqui le pasamos el comentario que queremos eliminar --}}
                                    Eliminar
                                </x-jet-dropdown-link>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>

                </div>

                @livewire('answer', compact('question'),key('answer-'.$question->id)){{-- Aqui le pasamos el id del comentario para que sepa a que comentario pertenece la respuesta --}}
            
            </li>
        @endforeach

    </ul>

    @if ($model->questions()->count() - $cant > 0) {{-- Solo se mostrara el boton si esta operacion es mayor a cero --}}
        <div class=" flex items-center">

            <hr class=" flex-1">

            <button wire:click='show_more_questions' class=" mx-4 font-semibold text-sm text-gray-500 hover:text-gray-600 ">

                Ver los {{ $model->questions()->count() - $cant }} comentarios restantes

            </button>

            <hr class=" flex-1">

        </div>
    @endif
    
    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/balloon/ckeditor.js"></script>
       {{--  <script>
            BalloonEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script> --}}
        
    @endpush
        
    

</div>
