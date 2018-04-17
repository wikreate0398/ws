<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    private $confirm_hash;

    private $site_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($confirm_hash)
    {
        $this->confirm_hash = $confirm_hash;
        $this->site_name   = request()->server('SERVER_NAME');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = url("registration-confirm/$this->confirm_hash"); 
        return $this->from('info@brainincorporated.com')
                    ->view('emails.registration')
                    ->with([
                        'confirm_hash' => $this->confirm_hash,
                        'theme'        => 'Вы успешно зарегистрировались на сайте ' . $this->site_name,
                        'msg'      => "<p>Что бы активировать свой профиль перейдите по <a href='$link'>ссылке</a></p>"
                    ])->subject('Регистрация на сайте ' . $this->site_name );
    }
}
