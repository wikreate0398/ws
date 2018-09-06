<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contacts extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@brainincorporated.com')
                    ->view('emails.default')
                    ->with([
                        'theme'    => 'Новое сообщени с формы обратной связи на сайте ' . request()->server('SERVER_NAME'),
                        'msg'      => $this->message
                    ])->subject('Новое сообщени с формы обратной связи');
    }
}
