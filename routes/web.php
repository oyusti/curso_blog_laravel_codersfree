<?php

use App\Http\Controllers\WelcomeController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', WelcomeController::class)->name('home');

/* Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
}); */

/* route::get('/prueba', function(){

   $files = Storage::makeDirectory('posts/posts2/prueba_final');
   return $files;

}); */

Route::get('/posts/{post}/image', function(Post $post){
    return Storage::download($post->image_url);
});

Route::get('image/post/{post}', function(Post $post){
    $images=Storage::get($post->image_url);
    return response($images)->header('Content-Type', 'image/jpeg');
})->name('image.post');


