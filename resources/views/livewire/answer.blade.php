<div class=" pl-16">
    {{-- Si  --}}
    <button wire:click="$set('answer_create.open', true)">
        <i class=" fas fa-reply"></i>
        Responder
    </button>

    {{-- Si le han dado click al boton responder ejecuta esto y me mostrara un formulario de respuesta al comentario--}}
    @if ($answer_create['open'])

        <div class=" flex">

            {{-- Agrego una imagen de perfil --}}
            <figure class=" mr-4">
                <img src="{{ $question->user->profile_photo_url }}" class="h-12 w-12 rounded-full object-cover">
            </figure>

            {{-- Agrego el textarea con sus botones de Cancelar y Editar --}}
            <form wire:submit.prevent="store()" class=" flex-1">

                <textarea wire:model="answer_create.body" rows="3"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                    placeholder="Escriba su respuesta"></textarea>

                <x-jet-input-error for="answer_create.body" class=" mt-1"></x-jet-input-error>

                <div class=" flex justify-end">

                    <x-jet-danger-button class=" mr-2" wire:click="$set('answer_create.open', false)">
                        Cancelar
                    </x-jet-danger-button>

                    <x-jet-button>
                        Responder
                    </x-jet-button>

                </div>

            </form>

        </div>

    @endif

    <ul class=" space-y-6 mt-4">

        @foreach ($this->answers as $answer)

            <li wire:key="answer-{{ $answer->id }}">{{-- Con esto Livewire sabe que item tiene que actualizar o eliminar --}}

                {{-- En esta seccion listo las respuestas a los comentarios --}}
                <div class=" flex">

                    {{-- Imagen de perfil del usuario que responde --}}
                    <figure class=" mr-4">
                        <img src="{{ $answer->user->profile_photo_url }}" class="h-12 w-12 rounded-full object-cover">
                    </figure>

                    {{-- Informacion del usuario que responde. Username, fecha de respuesta y el formulario de respuesta a una respuesta--}}
                    <div class="flex-1 mt-4">

                        <p class=" font-semibold">
                            {{ $answer->user->name }}

                            <span class=" text-sm font-normal">
                                {{ $answer->created_at->diffForHumans() }}
                            </span>
                        </p>

                        @if ($answer->id == $answer_edit['id'])
                            <form wire:submit.prevent="update">
                                <textarea wire:model="answer_edit.body" rows="3"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                                    placeholder="Escribe tu mensaje"></textarea>

                                <x-jet-input-error for="answer_edit.body"  class=" mt-1">

                                </x-jet-input-error>

                                <div class=" flex justify-end">
                                    <x-jet-danger-button class=" mr-2" wire:click="cancel">
                                        Cancelar
                                    </x-jet-danger-button>
                                    <x-jet-button>
                                        Actualizar
                                    </x-jet-button>
                                </div>
                            </form>
                        @else
                            <p>
                                {{ $answer->body }}
                            </p>
                        @endif

                        <button wire:click="$set('answer_to_answer.id', {{ $answer->id }})">
                            <i class=" fas fa-reply"></i>
                            Responder
                        </button>
                    </div>

                    {{-- En este div coloco el dropdown de Editar y Eliminar --}}
                    <div class=" ml-6">
                        <x-jet-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <i class=" fas fa-ellipsis-v"></i>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-jet-dropdown-link class=" cursor-pointer" wire:click="edit({{ $answer->id }})">

                                    Editar
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link class=" cursor-pointer" wire:click="destroy({{ $answer->id }})">

                                    Eliminar
                                </x-jet-dropdown-link>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>

                </div>

                {{-- Si hemos puslsado el boton responder, muestrame el formulario de respuesta --}}
                @if ($answer_to_answer['id'] == $answer->id)

                    {{-- Esta seccion muestra la imagen de perfil de quien responde, asi como el formulario del mismo --}}
                    <div class=" flex mt-4">

                        <figure class=" mr-4">
                            <img src="{{ $answer->user->profile_photo_url }}" class="h-12 w-12 rounded-full object-cover">
                        </figure>

                        <div class=" flex-1 mt-4">

                            <form wire:submit.prevent="answer_to_answer_store">
                                <textarea wire:model="answer_to_answer.body" rows="3"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                                    placeholder="Escribe tu mensaje"></textarea>

                                <x-jet-input-error for="answer_edit.body"  class=" mt-1"></x-jet-input-error>
                           
                                <div class=" flex justify-end">
                                    <x-jet-danger-button class=" mr-2" wire:click="$set('answer_to_answer.id', null)">
                                        Cancelar
                                    </x-jet-danger-button>
                                    <x-jet-button>
                                        Actualizar
                                    </x-jet-button>
                                </div>
                            </form>
                        </div>

                    </div>
                @endif

                {{-- @livewire('answer', compact('question'),key('answer-'.$question->id)){{-- Aqui le pasamos el id del comentario para que sepa a que comentario pertenece la respuesta --}}
            </li>
        @endforeach

    </ul>

</div>
