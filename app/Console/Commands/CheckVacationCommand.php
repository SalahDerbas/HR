<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\SendAnnualUserMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckVacationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check monthly vacation status for each user';

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
        $users = User::all();

        foreach ($users as $user) {
            $annual          = Setting::where('key', 'vacation_annual')->value('value');
            $availableAnnual = $annual - $user->getAnnualLeave();
            Log::channel('HR')->debug("[email: " . $user->email . "][user_id: " . $user->id. "][availableAnnual: " . $availableAnnual. "]  CheckVacationCommand");
            Mail::to($user->email)->send(new SendAnnualUserMail($user , $availableAnnual));
            $this->info("Sent available annual email to {$user->email}");
        }

        return 0;
    }
}
