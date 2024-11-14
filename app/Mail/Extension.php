<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Extension extends Mailable
{
    use Queueable, SerializesModels;

    public $userRoom, $user, $beforeExtension;

    /**
     * Create a new message instance.
     */
    public function __construct($userRoom, $user, $beforeExtension)
    {
        $this->userRoom = $userRoom;
        $this->user = $user;
        $this->beforeExtension = $beforeExtension;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Perpanjangan Sewa Berhasil',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.extension',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
