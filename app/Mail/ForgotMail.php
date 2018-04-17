<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotMail extends Mailable
{
    use Queueable, SerializesModels;

    private $site_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->site_name   = request()->server('SERVER_NAME');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        return $this->from('info@brainincorporated.com')
                    ->view('emails.forgot')
                    ->with([
                        'confirm_hash' => $this->confirm_hash,
                        'theme'        => 'Вы успешно зарегистрировались на сайте ' . $this->site_name,
                        'msg'      => "<p>Что бы активировать свой профиль перейдите по <a href='$link'>ссылке</a></p>"
                    ])->subject('Восстановление пароля на сайте ' . $this->site_name );
    }
}
