<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $this->email,
        ], false));
    
        return (new MailMessage)
            ->subject('🐾 Restablecer Contraseña - Veterinaria Huellitas')
            ->markdown('emails.custom-reset', [
                'url' => $url,
                'actionText' => 'Restablecer Contraseña'
            ]);
    }
    
}
