<x-admin-layout>
   
<form action="{{route('admin.categories.store')}}" method="POST">
    @csrf

    <div class=" bg-white rounded-lg p-6 shadow-lg">
        <x-jet-validation-errors class=" mb-4" />

        <div class=" mb-4">
            <x-jet-label for="name">
                Nombre
            </x-jet-label>

            <x-jet-input class=" w-full" name="name" value="{{ old('name') }}" id="name" type="text"
                placeholder="Escribe un nombre">

            </x-jet-input>
        </div>

        <div class=" flex justify-end">
            <x-jet-button>
                Crear Categoria
            </x-jet-button>
        </div>
    </div>


</form>


</x-admin-layout>