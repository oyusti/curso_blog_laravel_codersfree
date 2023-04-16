<?php

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

route::get('/tags/select2', function(Request $request){
    $term   =   $request->term ?: '';

    $tags   =   Tag::select('name')->where('name', 'like', '%' . $term . '%')
                    ->get()->map(function($tag){
                        return [
                            'id'    =>  $tag->name,
                            'text'  =>  $tag->name
                        ];
                    });
    return $tags;
})->name('tags.select2');
