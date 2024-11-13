<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\SendBirthdayMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendBirthdayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send birthday emails to users whose birthday is today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get users with today's birthday
        $users = User::whereRaw('MONTH(date_of_brith) = ?', [Carbon::now()->month])
                     ->whereRaw('DAY(date_of_brith)   = ?', [Carbon::now()->day])
                     ->get();

        foreach ($users as $user) {
            Log::channel('HR')->debug("[email: " . $user->email . "][user_id: " . $user->id. "] SendBirthdayCommand");
            Mail::to($user->email)->send(new SendBirthdayMail($user));
            $this->info("Sent birthday email to {$user->email}");
        }

        return 0;
    }
}
