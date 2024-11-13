<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAnnualUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $availableAnnual;
    public function __construct($user , $availableAnnual)
    {
        $this->user = $user;
        $this->availableAnnual = $availableAnnual;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::channel('HR')->debug("[user_id: " . $this->user['id']. "] SendAnnualUserMail");

        return $this->subject('Available Annual User!')->view('emails.annual_user_email')->with(['user'=> $this->user , 'availableAnnual' => $this->availableAnnual]);
    }
}
