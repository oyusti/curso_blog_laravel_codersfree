<x-admin-layout>
   
    <form action="{{route('admin.categories.update', $category)}}" method="POST">
        @method('PUT')
        @csrf
    
        <div class=" bg-white rounded-lg p-6 shadow-lg">
            <x-jet-validation-errors class=" mb-4" />
    
            <div class=" mb-4">
                <x-jet-label for="name">
                    Nombre
                </x-jet-label>
    
                <x-jet-input class=" w-full" name="name" value="{{ old('name', $category->name) }}" id="name" type="text">
    
                </x-jet-input>
            </div>
    
            <div class=" flex justify-end">
                <!--Pregunto si la categoria tiene post, si no tiene post, se muestra el boton de eliminar-->
                <x-jet-danger-button class=" mr-2" type="button" onclick="deleteCategory()" :disabled="$category->posts->count()!=0">
                    Eliminar Categoria
                </x-jet-danger-button>
                <x-jet-button>
                    Actualizar Categoria
                </x-jet-button>
            </div>
        </div>
    
    
    </form>
    <!--Pregunto si la categoria tiene post, si tiene post asociado no me muestra el formulario y por ende no se podra eliminar-->
    @if ($category->posts->count()==0)
        <form action="{{route('admin.categories.destroy', $category)}}" method="POST" id="FormDeleteCategory">
            @csrf
            @method('DElETE')
        </form>
    @endif

   

    @push('js')
        <script>
            function deleteCategory(){
                form=document.getElementById("FormDeleteCategory");
                form.submit();
            } 
        </script>
    @endpush
    

</x-admin-layout>