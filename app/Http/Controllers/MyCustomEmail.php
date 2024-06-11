<?php

namespace App\Http\Controllers;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyCustomEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;

    /**
     * @param mixed $subject
     * @param mixed $message
     */
    public function __construct(mixed $subject, mixed $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }
    public function build()
    {
        return $this->view('emails.custom-plan-email')
            ->subject($this->subject)
            ->with([
                'message' => $this->message,
            ]);
    }
}
