<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOTPEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     * @author Salah Derbas
     */
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @author Salah Derbas
     */
    public function build()
    {
        Log::channel('HR')->debug("[data: " . $this->data. "] SendOTPEmailMail");
        return $this->from(env('MAIL_USERNAME'))->subject('Verify Your E-mail')->view('emails/verify_email')->with('data', $this->data);
    }
}
