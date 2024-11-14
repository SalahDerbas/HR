<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\SendJoinDateMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendJoinDateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * @author Salah Derbas
    */
    protected $signature = 'email:joindate';

    /**
     * The console command description.
     *
     * @var string
     * @author Salah Derbas
    */
    protected $description = 'Send JoinDate emails to users whose JoinDate is today';

    /**
     * Create a new command instance.
     *
     * @return void
     * @author Salah Derbas
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @author Salah Derbas
    */
    public function handle()
    {
        // Get users with today's birthday
        $users = User::whereRaw('MONTH(join_date) = ?', [Carbon::now()->month])
                     ->whereRaw('DAY(join_date)   = ?', [Carbon::now()->day])
                     ->get();

        foreach ($users as $user) {
            Log::channel('HR')->debug("[email: " . $user->email . "][user_id: " . $user->id. "] SendJoinDateCommand");
            Mail::to($user->email)->send(new SendJoinDateMail($user));
            $this->info("Sent join_date email to {$user->email}");
        }

        return 0;
    }
}
