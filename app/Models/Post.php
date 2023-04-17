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
    
    /* //Route Model Binding
        public function getRouteKeyName()
        {
            return 'slug';
        } */
   
}
