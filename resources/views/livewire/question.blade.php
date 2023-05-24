<div>
    <div class=" flex">
        <figure class=" mr-4">

            <img class="h-12 w-12 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="">

        </figure>
        <div class=" flex-1">

            <form wire:submit.prevent="store">

                <textarea wire:model="message" rows="3" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full" placeholder="Escribe tu mensaje">

                </textarea>

                <div class=" flex justify-end mt-2">
                    <button class=" bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Comentar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
