<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CourseRequestMail extends Mailable
{
    use Queueable, SerializesModels; 
 
    protected $_course;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course)
    { 
        $this->_course = $course;
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
                        'theme' => 'Заявка на курс',
                        'msg'   => "<p>Пользователь по имени ". $this->_course->user->name ." записался на курс</p>"
                    ])->subject('Новая запись на курс на сайте ' . request()->server('SERVER_NAME') );
    }
}
