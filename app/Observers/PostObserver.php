<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class PostObserver
{
    public function creating(Post $post)
    { //'creating' se usa para antes de ejecutar el evento para despues usamos 'created'

        if (!app()->runningInConsole()) {//solo se ejecutara este codigo si no se esta creando los registros por consola
            //$post->slug =  Str::slug($post->title); no lo usaremos porque crearemos un campo para que el usuario ingrese el slug
            $post->user_id = auth()->id();
        }
    }

    public function updating(Post $post){
        if ($post->is_published && is_null($post->published_at)){
            $post->published_at = now();
        }
    }
}
