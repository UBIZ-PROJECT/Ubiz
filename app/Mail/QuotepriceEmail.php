<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuotepriceEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('quoteprice_mail')
            ->subject($this->data['subject'])
            ->attach($this->data['file_path'], [
                'as' => $this->data['file_name'],
                'mime' => 'application/pdf',
            ])
            ->with(['data' => $this->data]);
    }
}
