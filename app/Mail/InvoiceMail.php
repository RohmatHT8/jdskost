<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdfFilePath;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $pdfFilePath)
    {
        $this->data = $data;
        $this->pdfFilePath = $pdfFilePath;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Kwitansi Pembayaran JDS KOST')
            ->view('emails.invoice')
            ->attach($this->pdfFilePath, [
                'as' => 'invoice.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
