<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function show(Post $post){

        $this->authorize('published', $post);//forma corta demostrar el error 403

        //Esta forma es mas flexible para mostrar el error 403
        /* if(!Gate::allows('published', $post)){
            abort(403);
        } */
        return view('posts.show', compact('post'));
    }
}
