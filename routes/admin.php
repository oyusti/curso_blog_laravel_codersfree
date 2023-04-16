<?php
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

route::get('/', function(){
    return view('admin.dashboard');
})->name('dashboard');

route::resource('posts', PostController::class);

route::resource('categories', CategoryController::class);