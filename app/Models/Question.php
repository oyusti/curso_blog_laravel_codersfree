<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable=[
        'body',
        'user_id'
    ];

    //
    public function answers(){
        return $this->hasMany(Answer::class);
    }

    //Relacion Uno a Muchos Inversa
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    //Relacion Uno a Muchos Polimorfica
    public function questionable(){
        return $this->morphTo();
    }

    
}
