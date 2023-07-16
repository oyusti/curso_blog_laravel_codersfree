<?php

namespace App\Listeners;

use App\Mail\NotifyAuthorMailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAuthor
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        switch ($event->question->questionable_type) {//Preguntamos que modelo es
            case 'App\Models\Post'://Si es un post
                $post = $event->question->questionable;//recuperamos el post
                $author = $post->user;//recuperamos el autor del post

                Mail::to($author->email)->send(new NotifyAuthorMailable($event->question, $author));//enviamos el correo
                break;
            
            default:
                # code...
                break;
        }
    }
}
