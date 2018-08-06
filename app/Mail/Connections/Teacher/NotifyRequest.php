<?php

namespace App\Mail\Connections\Teacher;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyRequest extends Mailable
{
    use Queueable, SerializesModels;  

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        //return;
        return $this->from('info@brainincorporated.com')
                    ->view('emails.default')
                    ->with([ 
                        'theme' => 'Новый запрос на сайте ' . request()->server('SERVER_NAME'),
                        'msg'   => "<p>Новая заявка для участия в Учебном заведении</p>"
                    ])->subject('Новый запрос на сайте ' . request()->server('SERVER_NAME') );
    }
}
