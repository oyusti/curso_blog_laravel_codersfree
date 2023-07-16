<?php

namespace App\Mail;

use App\Models\Question;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyAuthorMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $question;
    public $author;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Question $question, User $author)
    {
        $this->question = $question;
        $this->author = $author;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Nuevo Comentario',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mails.NotifyAuthor',
            with: [
                'question' => $this->question,
                'author' => $this->author,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
