<?php

namespace App\Mail\Course;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeclineRequest extends Mailable
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
                        'theme' => 'Запрос откланен',
                        'msg'   => "<p>Ваш запрос на курс <a href='/course/{$this->course['id']}'>{$this->course['name']}</a> к сожалению откланен. Попробуйте повторить через короткое время.</p>"
                    ])->subject('Запрос на курс откланен на сайте ' . request()->server('SERVER_NAME') );
    }
}
