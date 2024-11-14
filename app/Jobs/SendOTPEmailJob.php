<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTPEmailMail;

class SendOTPEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $email;
    protected $otp;
    /**
     * Create a new job instance.
     *
     * @return void
     * @author Salah Derbas
     */
    public function __construct($email , $otp)
    {
        $this->email = $email;
        $this->otp   = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @author Salah Derbas
     */
    public function handle()
    {
        $data = ['email' => $this->email , 'otp'=> $this->otp ];
        // Mail::to( $this->email )->send( new SendOTPEmailMail($data) );
    }
}
