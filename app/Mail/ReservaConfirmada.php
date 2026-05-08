<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaConfirmada extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // 1. Creamos dos propiedades públicas para almacenar la reserva y la URL de cancelación que nos pasará el controlador
    public $reserva;
    public $urlCancelacion;
    

    // 2. Cuando el controlador llame a este correo, nos pasará la reserva
    public function __construct(Reserva $reserva, $urlCancelacion)
    {
        $this->reserva = $reserva;
        $this->urlCancelacion = $urlCancelacion;
    }

    // 3. El asunto del correo
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Tu reserva en CD Montecanal está confirmada!',
        );
    }

    // 4. Qué plantilla visual va a utilizar
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reservas.confirmacion',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}