<?php

namespace App\Mail\Connections\Teacher;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeclineRequest extends Mailable
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
                        'theme' => 'Запрос откланен',
                        'msg'   => "<p>Ваша заявка Учебному заведению отклонена. Попробуйте отправить запрос и составить более детальное письмо.</p>"
                    ])->subject('Отклонение заявки на сайте ' . request()->server('SERVER_NAME') );
    }
}
