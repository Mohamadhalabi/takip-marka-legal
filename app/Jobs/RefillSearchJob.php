<?php

namespace App\Jobs;

use App\Models\TestLimit;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class RefillSearchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $created = new Carbon($user->subscription_ends_on);
        $now = Carbon::now();
        $difference = ($created->diff($now)->days < 1)
            ? 'today'
            : $created->diffForHumans($now);

        if ($difference == "today") {

            $userPlan = User::where('id',$user->id)->first();

            // Plan limits
            $keyword_limit = $userPlan->keyword_limit;
            $search_limit = $userPlan->search_limit;
            $landscape_search_limit = $userPlan->landscape_limit;


            // Reset user current limits according to his plan

            //keyword limit
            TestLimit::where('user_id', $user->id)->update(["keyword_limit" => $keyword_limit]);

            //regular search limit
            TestLimit::where('user_id', $user->id)->update(["limit" => $search_limit]);

            //landscape search limit
            TestLimit::where('user_id', $user->id)->update(["landscape_limit" => $landscape_search_limit]);

            //Reset subscription date
            User::where('id', $user->id)->update([
                "subscription_ends_on" => Carbon::parse($user->subscription_ends_on)->addDays(30)->toDateString()
            ]);
        }
    }
}
