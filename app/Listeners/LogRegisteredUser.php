<?php

namespace App\Listeners;

use App\Models\TestLimit;
use App\Models\Tour;
use App\Models\UserActivity;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class LogRegisteredUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Assign default role : user
        $event->user->assignRole('user');

        TestLimit::create([
            'user_id' => $event->user->id,
            'limit' => 20
        ]);

        Tour::create([
            'user_id' => $event->user->id,
            'dashboard' => true,
            'report' => true,
            'keyword' => true
        ]);

        // Log user activity : registered
        UserActivity::create([
            'user_id' => $event->user->id,
            'event' => __('theme/dashboard.registered'),
        ]);

        $token = Str::random(64);

        UserVerify::create([
            'user_id' => $event->user->id,
            'token' => $token
            ]);

        Mail::send('emails.verification', ['token' => $token], function($message) use($event){
              $message->to($event->user->email);
              $message->subject('Hesabınızı doğrulayın | '.env('APP_NAME'));
          });
    }
}
