<?php

namespace App\Console\Commands;

use App\Jobs\RefillSearchJob;
use App\Models\User;
use Illuminate\Console\Command;

class RefillLimitSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refill:limits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refill users search limits';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user)
        {
            RefillSearchJob::dispatch($user);
        }
    }
}
