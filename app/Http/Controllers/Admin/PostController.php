<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        return redirect()->route('admin.posts.edit', $post);
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
    public function update(UpdatePostRequest $request, Post $post)
    {
        $tags=[];

        foreach ($request->tags ?? [] as $name) {
            $tag = Tag::firstOrCreate(['name'=>$name]);
            $tags[]=$tag->id;
        }

        

        $post->tags()->sync($tags);
        $post->update($request->all());

        //pregunto si en la informacion traida hay una imagen y si es asi la subo al almacenamiento
        //el primer parametro representa la carpeta donde se guardara las imagenes que tendra la ruta public/storage/posts en este caso
        //el segundo parametro representa el archivo que me traigo del formulario
        if ($request->hasFile('image')){
            //Pregunto si ya existe una imagen asociada al post y de ser asi la elimino
            if($post->image_url){
                Storage::delete($post->image_url);
            }
            
            //Para darle nombre a las imagenes utilizamos el mismo nombre del slug y lo concatenamos con la extension de la imagen
            $nameFile=Str::slug($request->slug) . '.' . $request->image->extension();
            //Luego subimos la imagen con "PutFileAs" que admite 3 parametros, la ruta, la imagen y el nombre del archivo
            $image_url=Storage::disk('s3')->putFileAs('posts', $request->image, $nameFile, 'public');

            //Con esto subimos las imagenes pero no le cambiamos el nombre, para eso usamos "putFileAs"
            //$image_url=Storage::put('posts', $request->file('image'));


            //Otra forma de lograr esto es con request storeAs
            //Creamos la variable del nombre
            /* $nameFile=Str::slug($request->slug) . '.' . $request->image->extension();
            //Subimos la imagen con cualquiera de las dos formas propuestas a continuacion
            $image_url=$request->file('image')->storeAs('posts', $nameFile, [
                'visibility'=>'public'
            ]); */
            //$image_url=$request->image->storeAs('posts', $nameFile);

            
            //Hasta ahora hemos subido la imagen a la carpeta pero no a la base de datos
            $post->image_url=$image_url;
            $post->save();
            
        }

        //Codigo para crear el baner
        session()->flash('flash.banner', 'El Post se ha actualizado con exito');//se utiliza para dar mensajes flash, aqui especifico el nombre del mensaje
        session()->flash('flash.bannerStyle', 'success');//Aqui especifico si 'success' o 'danger'. puedo dar estos dos mensajes

        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        session()->flash('flash.banner', 'El Post se ha eliminado con exito');
        session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('admin.posts.index');
    }
}
