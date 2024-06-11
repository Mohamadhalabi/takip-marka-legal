<?php

namespace App\Console\Commands;

use App\Jobs\CreatePeriodicReport;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report Generator';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get all users.
        $users = User::all();
        // Loop through users for report generation.
        foreach ($users as $user)
        {
            if($user->id == 52){
                CreatePeriodicReport::dispatch($user);
            }
        }
    }
}
