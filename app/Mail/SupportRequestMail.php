<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupportRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $messageText;
    public $userName;
    public $userEmail;

    public function __construct($subject, $message, $name, $email)
    {
        $this->subjectText = $subject;
        $this->messageText = $message;
        $this->userName = $name;
        $this->userEmail = $email;
    }

    public function build()
    {
        return $this->subject('Новое обращение в поддержку')
                    ->view('emails.support_request');
    }
}