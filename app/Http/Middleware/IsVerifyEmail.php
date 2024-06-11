<?php

namespace App\Http\Middleware;

use App\Models\UserVerify;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class IsVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->is_email_verified) {
            $user = Auth::user();
            $timeToWait = UserVerify::where('user_id', $user->id)->latest()->first()->created_at ?? null;
            if (!$timeToWait) {
                return $next($request);
            }
            $second = 180 - now()->diffInSeconds($timeToWait);
            $second = $second >= 180 ? 0 : $second;
            auth()->logout();

            $referer = $request->headers->get('referer');
            $urlParts = explode ('/', $referer);
            App::setLocale($urlParts[3]);

            return redirect()->route('login', ['locale' => app()->getLocale()])
                ->with('user', $user)
                ->with('code', 're-verification')
                ->with('second', $second);
        }

        return $next($request);
    }
}
