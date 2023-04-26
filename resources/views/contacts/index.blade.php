<x-app-layout>

    <section class=" max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class=" bg-white p-8 rounded-lg shadow-lg">

            <form action="" method="Post">
                @csrf

                <x-jet-validation-errors class=" mb-4" />

                <div class=" mb-4">
                    
                    <x-jet-label>
                        Nombre:
                    </x-jet-label>

                    <x-jet-input type="text" class="w-full" value="{{old('name')}}" name="name" placeholder="Escriba su Nombre"/>

                </div>

                <div class=" mb-4">
                    
                    <x-jet-label>
                        Correo:
                    </x-jet-label>

                    <x-jet-input type="text" class="w-full" value="{{old('email')}}" name="email" placeholder="Escriba su Correo"/>

                </div>

                <div class=" mb-4">
                    
                    <x-jet-label>
                        Mensaje:
                    </x-jet-label>

                    <textarea name="message" class="w-full" 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm'" rows="6" placeholder="Escriba su Mensaje">{{old('message')}}</textarea>

                </div>

                <div class=" flex justify-end">
                    <x-jet-button>
                        Enviar
                    </x-jet-button>
                </div>

            </form>

        </div>

    </section>

</x-app-layout>