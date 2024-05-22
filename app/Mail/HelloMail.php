<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;
class HelloMail extends Mailable
{
    use Queueable, SerializesModels;
    public $verificationCode;

    /**
     * Create a new message instance.
     */
    public function __construct( string  $verificationCode)
    {
        $this->verificationCode = $verificationCode;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email',

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.pass',
            with: ['verificationCode' => $this->verificationCode
            ]
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
