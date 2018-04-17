<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    } 

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        if (empty($request->input('email'))) 
        {
            return \App\Utils\JsonResponse::error(['messages' => ['email' => 'Укажите свой E-mail']]); 
        }

        $user = User::whereEmail($request->input('email'))->first();
        if (empty($user)) 
        {
            return \App\Utils\JsonResponse::error(['messages' => ['email' => 'Пользователь не существует']]); 
        }  

        //$this->sendEmail($user, $email);
    }

    // private function sendEmail($user, $email)
    // {
    //     Mail::to($email)->send(new ForgotMail($hash)); 
    // }
}
