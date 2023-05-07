<?php

namespace App\Http\Controllers;

use App\Mail\ContactMailable;
use Illuminate\Http\Request;
//use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Mail;


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

        
        Mail::to('oscar@gmail.com')->send(new ContactMailable($request->all()));

        return 'Mensaje enviado';
        
    }

    
}


