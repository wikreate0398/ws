<?php

namespace App\Mail\Course\Homework;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyTeacher extends Mailable
{
    use Queueable, SerializesModels; 

    private $course; 

    private $lecture;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course, $lecture) 
    {
        $this->course = $course;
        $this->lecture = $lecture;
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
                        'theme' => 'Домашнее задание',
                        'msg'   => "<p>Пользователь отправил домашнее задание <i>{$this->course->name} -> {$this->lecture->section->name} -> {$this->lecture->name}</i> .</p>"
                    ])->subject('Домашнее задание на проверку на сайте ' . request()->server('SERVER_NAME') );
    }
}
