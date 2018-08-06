<?php

namespace App\Mail\Connections\Teacher;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DestroyRequest extends Mailable
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
        return $this->from('info@brainincorporated.com')
                    ->view('emails.default')
                    ->with([ 
                        'theme' => 'Запрос удален',
                        'msg'   => "<p>Учебное заведение удалили вашу привязку</p>"
                    ])->subject('Удаление заявки на сайте ' . request()->server('SERVER_NAME') );
    }
}
