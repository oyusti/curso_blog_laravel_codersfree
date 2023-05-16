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
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'min:10|max:500'
        ]);

            if ($request->hasFile('file')) {
                $data['file'] = $request->file->store('contacts');
            }
        
        Mail::to('oscar@gmail.com')->send(new ContactMailable($data));

        session()->flash('flash.banner', 'El Correo se ha enviado satisfactoriamente');//se utiliza para dar mensajes flash, aqui especifico el nombre del mensaje
        session()->flash('flash.bannerStyle', 'success');//Aqui especifico si 'success' o 'danger'. puedo dar estos dos mensajes


        return back();
        
    }

    
}


