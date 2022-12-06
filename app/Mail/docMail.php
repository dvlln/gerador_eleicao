<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class docMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $resposta, $motivo, $inicioData, $fimData)
    {
        $this->url = $url;
        $this->resposta = $resposta;
        $this->motivo = $motivo;
        $this->inicioData = $inicioData;
        $this->fimData = $fimData;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Aprovação do documento de inscrição',
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
            markdown: 'emails.eleicao.docMail',
            with: [
                'url' => $this->url,
                'resposta' => $this->resposta,
                'motivo' => $this->motivo,
                'inicioData' => $this->inicioData,
                'fimData' => $this->fimData,
            ]
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
