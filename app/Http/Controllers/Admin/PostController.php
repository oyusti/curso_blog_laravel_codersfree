<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
//use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts  =   Post::where('user_id', auth()->user()->id)
                            ->orderBy('id', 'desc')
                            ->paginate(10);//buscame todos los post del usuario que esta logueado
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories   =   Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         =>  'required|string|max:255', //solo se permite string maximo 255 caracteres
            'slug'         =>  'required|string|max:255|unique:posts',
            'category_id'   =>  'required|integer|exists:categories,id', //solo se permite entero y que exista la variable categories_id
        ]);

        $post   =   Post::create($request->all());
        /* $post   =  Post::create([
            'title'         =>  $request->title,
            'slug'          =>  Str::slug($request->title),//Str necesario para crear el slug
            'category_id'   =>  $request->category_id,
            'user_id'       =>  auth()->id(), // enviamos el user_id del usuario logueado en ese momento
        ]); */

        session()->flash('flash.banner', 'El Post se ha creado con exito');//se utiliza para dar mensajes flash, aqui especifico el nombre del mensaje
        session()->flash('flash.bannerStyle', 'success');//Aqui especifico si 'success' o 'danger'. puedo dar estos dos mensajes

        return redirect()->route('admin.post.edit', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories =   Category::all();        
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'         =>  'required|string|max:255', //solo se permite string maximo 255 caracteres
            'slug'          =>  'required|string|max:255|unique:posts,slug,' .$post->id,
            'category_id'   =>  'required|integer|exists:categories,id', //solo se permite entero y que exista la variable categories_id
            'summary'       =>  'required|string',
            'content'       =>  'required|string',
        ]);
        $post->tags()->sync($request->tags);
        $post->update($request->all());

        session()->flash('flash.banner', 'El Post se ha creado con exito');//se utiliza para dar mensajes flash, aqui especifico el nombre del mensaje
        session()->flash('flash.bannerStyle', 'success');//Aqui especifico si 'success' o 'danger'. puedo dar estos dos mensajes

        return redirect()->route('admin.post.edit', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
