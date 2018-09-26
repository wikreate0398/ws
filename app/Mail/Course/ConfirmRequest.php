<?php

namespace App\Mail\Course;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmRequest extends Mailable
{
    use Queueable, SerializesModels; 

    private $course; 

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($course) 
    {
        $this->course = $course;
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
                        'theme' => 'Подтверждение заявки',
                        'msg'   => "<p>Вы успешно записаны на курс <a href='/course/{$this->course['id']}'>{$this->course['name']}</a>.</p>
                                    <p>Начало : ". date('d.m.Y', strtotime($this->course['date_from'])) ."</p>
                                    <p>Все подробности в личном кабинете в разделе Мои Курсы->О Курсе</p>"
                    ])->subject('Подтверждение заявки на курс на сайте ' . request()->server('SERVER_NAME') );
    }
}
