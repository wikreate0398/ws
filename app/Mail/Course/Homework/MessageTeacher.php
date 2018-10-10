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

    private $file;  

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course, $user, $file = null) 
    {
        $this->course = $course; 
        $this->user = $user; 
        $this->file = $file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('info@brainincorporated.com')
                     ->view('emails.default')
                     ->with([ 
                        'theme' => 'Новое сообщение',
                        'msg'   => "<p>Пользователь по имени {$this->user->name} отправил сообщение с курса <i>{$this->course->name}</i> .</p>"
                     ])->subject('Новое сообщение на сайте ' . request()->server('SERVER_NAME'));

        if (!empty($this->file)) 
        {
            $mail->attach(public_path() . '/uploads/courses/message/' . $this->file);
        }

        return $mail;
    }
}
