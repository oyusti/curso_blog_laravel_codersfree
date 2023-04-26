<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContacController extends Controller
{
    public function index(){
        return view('contacts.index');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'min:10|max:500'
        ]);
    }
}
