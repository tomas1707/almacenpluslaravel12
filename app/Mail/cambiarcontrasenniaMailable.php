<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class cambiarcontrasenniaMailable extends Mailable
{
    use Queueable, SerializesModels;
    private $nombreCompleto;
    private $token;

    public function __construct($nombrecompleto, $token)
    {
        $this->nombreCompleto = $nombrecompleto;
        $this->token = $token;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env("MAIL_FROM_ADDRESS"),'Tomás González'),
            subject: 'Cambiar contraseña',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'ResetPasswordViews.mensajecambiarcontrasennia',
            with: [
                'nombreCompleto' => $this->nombreCompleto,
                'token' => $this->token,
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
