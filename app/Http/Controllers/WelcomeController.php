<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::all();
        
        $posts = Post::where('is_published', true)
                ->Filter(request()->all())//Enviamos todo lo que recuperamos por la url y esto es un array
                ->orderBy('id', 'desc')
                ->paginate(10);

        return view('welcome', compact('posts', 'categories'));
    }
}
