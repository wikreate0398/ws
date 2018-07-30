<?php

namespace App\Mail\Connections\Teacher;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteTeacher extends Mailable
{
    use Queueable, SerializesModels;  

    private $university;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($university) 
    {
        $this->university = $university;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        $message = '<p>Учебное заведение под названием <strong>'.$this->university->university->full_name.'</strong> отправил вам запрос для участия.</p>';
        return $this->from('info@brainincorporated.com')
                    ->view('emails.default')
                    ->with([ 
                        'theme' => 'Сообщение с сайте ' . request()->server('SERVER_NAME'),
                        'msg'   => $message
                    ])->subject('Приглашение для участия на сайте ' . request()->server('SERVER_NAME'));
    }
}
