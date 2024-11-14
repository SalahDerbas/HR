<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendBirthdayMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     * @author Salah Derbas
     */
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @author Salah Derbas
     */
    public function build()
    {
        Log::channel('HR')->debug("[user_id: " . $this->user['id']. "] SendBirthdayMail");
        return $this->subject('Happy Birthday!')->view('emails.birthday_email')->with(['user' => $this->user]);
    }
}
