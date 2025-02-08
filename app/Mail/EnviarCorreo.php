<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnviarCorreo extends Mailable
{
    use Queueable, SerializesModels;
    public $nombreCliente;

    /**
     * Create a new message instance.
     */
    public function __construct($nombreCliente)
    {
        $this->nombreCliente = $nombreCliente;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Su servicio de lavandería está listo!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'primary.clientes.clientescorreo',
            with: ['nombreCliente' => $this->nombreCliente]
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
