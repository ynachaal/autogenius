<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Services\EmailService;

class CustomResetPassword extends Notification
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
   
        $request = new \stdClass();
        $request->name = $notifiable->name ?? 'User';
        $request->email = $notifiable->email;
        $request->reset_url = $resetUrl;

          

        // Send your custom email
        (new EmailService())->ForgetPassword($request);

        // need to return a MailMessage object, but it won't be used to send email
        return (new MailMessage)
            ->mailer('log')  // sends to storage/logs/laravel.log only
            ->subject('Password Reset')
            ->line('Handled by custom EmailService');
    }
}
