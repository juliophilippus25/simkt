<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyWithRoom extends Mailable
{
    use Queueable, SerializesModels;
    public $appliedResidency;
    public $userRoom;
    public $room;
    public $now;
    /**
     * Create a new message instance.
     */
    public function __construct($appliedResidency, $userRoom, $room, $now)
    {
        $this->appliedResidency = $appliedResidency;
        $this->room = $room;
        $this->userRoom = $userRoom;
        $this->now = $now;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengajuan Penghuni dan Pembayaran Diterima',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.verify_with_room',
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
