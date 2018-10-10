<?php

namespace App\Mail\Course;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageTeacher extends Mailable
{
    use Queueable, SerializesModels; 

    private $course;  

    private $user;  

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course, $user) 
    {
        $this->course = $course; 
        $this->user = $user; 
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
                        'theme' => 'Новое сообщение',
                        'msg'   => "<p>Пользователь по имени {$this->user->name} отправил сообщение с курса <i>{$this->course->name}</i> .</p>"
                    ])->subject('Новое сообщение на сайте ' . request()->server('SERVER_NAME') );
    }
}
