<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TeacherRequestMail extends Mailable
{
    use Queueable, SerializesModels; 
 
    protected $_teacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($teacher)
    { 
        $this->_teacher = $teacher;
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
                        'theme' => 'Заявка учителю',
                        'msg'   => "<p>Пользователь по имени ". $this->_teacher->name ." оставил заявку</p>"
                    ])->subject('Новая заявка учителю на сайте ' . request()->server('SERVER_NAME') );
    }
}
