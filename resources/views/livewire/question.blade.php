<div>
    <div class=" flex">
        <figure class=" mr-4">

            <img class="h-12 w-12 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="">

        </figure>
        <div class="flex-1">

            <form wire:submit.prevent="store">

                <textarea wire:model.defer="message" rows="3"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                    placeholder="Escribe tu mensaje"></textarea>

                <x-jet-input-error for="message" class=" mt-2" />

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

    <ul class=" space-y-6">

        @foreach ($questions as $question)
            <li wire:key="question-{{ $question->id }}">{{-- Con esto Livewire sabe que item tiene que actualizar o eliminar --}}
                <div class=" flex">
                    <figure class=" mr-4">
                        <img src="{{ $question->user->profile_photo_url }}" class="h-12 w-12 rounded-full object-cover">
                    </figure>

                    <div class="flex-1">
                        <p class=" font-semibold">
                            {{ $question->user->name }}

                            <span class=" text-sm font-normal">
                                {{ $question->created_at->diffForHumans() }}
                            </span>
                        </p>

                        @if ($question->id == $question_edit['id'])
                            <form wire:submit.prevent="update">
                                <textarea wire:model="question_edit.body" rows="3"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                                    placeholder="Escribe tu mensaje"></textarea>

                                <x-jet-input-error for="question_edit.body"  class=" mt-1">

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
                                {{ $question->body }}
                            </p>
                        @endif

                    </div>

                    <div>
                        <x-jet-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <i class=" fas fa-ellipsis-v"></i>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-jet-dropdown-link class=" cursor-pointer" wire:click="edit({{ $question->id }})">
                                    {{-- Aqui le pasamos el comentario que queremos editar --}}
                                    Editar
                                </x-jet-dropdown-link>

                                <x-jet-dropdown-link class=" cursor-pointer" wire:click="destroy({{ $question->id }})">
                                    {{-- Aqui le pasamos el comentario que queremos eliminar --}}
                                    Eliminar
                                </x-jet-dropdown-link>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>

                </div>
            </li>
        @endforeach

    </ul>

    @dump($question_edit)

</div>
