<?php

use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;

route::get('/', function(){
    return view('admin.dashboard');
})->name('dashboard');

route::resource('post', PostController::class);