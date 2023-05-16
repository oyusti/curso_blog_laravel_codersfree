<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'image_url',
        'is_published',
        'published_at',
        'user_id',
        'category_id'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];


    public function image():Attribute{
        return new Attribute(
            get: function(){
                //return $this->image_url ? Storage::temporaryUrl($this->image_url, now()->addMinutes(2)) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80';
                //return $this->image_url ? route('image.post', $this) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80';
                return $this->image_url ? Storage::disk('s3')->url($this->image_url) : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80';
            }
        );
    }

    // aqui usamos un accesor para modificar el titulo del Post
    /* public function title():Attribute {
        return new Attribute(
            get: function($value){
                return strtoupper($value);
            }
        );
    } */

    //Relacion Uno a Muchos Inversa
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relacion Uno a Muchos Inversa
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Relacion Muchos a Muchos
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function scopeFilter($query, $filters){//$filters tiene el array que traigo de la url
        //Con When si el primer parametro me devuelve true entonces me ejecuta la funcion que le paso como segundo parametro
        //Si category existe, entonces me ejecuta la funcion anonima(segundo parametro) que tiene como objetivo recuperarme
        //los post que tengan la categoria que le estoy pasando por la url. 
        //Como request('category') es un array entonces no puedo usar where
        //en la consulta. Con whereIn le indicamos que busque el category_id dentro del array request('category')
        $query->when($filters['category'] ?? null, function ($query, $category) {
            $query->whereIn('category_id', $category);
        })
        //Si el request('order') existe entonces me ejecuta la funcion anonima que tiene como objetivo
        //ordenar los post por fecha de publicacion. Si el request('order') es igual a new entonces
        //me ordena de forma descendente, si no me ordena de forma ascendente
        ->when($filters['order'] ?? 'new', function($query, $order){
            $sort = $order == 'new' ? 'desc' : 'asc';
            $query->orderBy('published_at',$sort);
        })->when($filters['tag'] ?? null, function($query, $tag){//usamos "whereHas" porque queremos solo las etiquetas relacionadas con el post
            $query->whereHas('tags', function($query) use ($tag){//usamos "use" porque $tag es una variable que solo esta dentro de la funcion anonima
                $query->where('tags.name', $tag);//tags.name es el nombre de la tabla tags y $tag es el nombre del tag que le estoy pasando por la url y solo esta dentro de la funcion anonima
            });
        });
        
        // ->when($filters['search'] ?? null, function($query, $search){
        //     $query->where('title', 'like', '%'.$search.'%')
        //         ->orWhere('summary', 'like', '%'.$search.'%')
        //         ->orWhere('content', 'like', '%'.$search.'%');
        // });
    }
    
    /* //Route Model Binding
        public function getRouteKeyName()
        {
            return 'slug';
        } */

    protected static function booted(){

        //Cuando se crea un post, se le asigna el id del usuario que esta autenticado
        //Con esto todos los posts solo pueden ser editados por el usuario que los creo
        /* static::addGlobalScope('written', function($query){
            if(request()->routeIs('admin.*')){//Solo se ejecuta cuando estamos en la ruta admin
                $query->where('user_id', auth()->id());
            }
        });
 */

 

        /* static::addGlobalScope('published', function($query){
            if(!request()->routeIs('admin.*')){//Solo se ejecuta cuando no estamos en la ruta admin
                $query->where('is_published', true);
            }
        }); */

    }    
   
}
