<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    /**
     * Send verification link to user email
     *
     * @param  mixed $request
     * @return void
     */
    public function sendLink(Request $request)
    {
        $token = Str::random(64);
        $user = User::find($request->user_id);
        $verify = UserVerify::where('user_id', $request->user_id)->latest()->first();

        if(!$verify || ($verify && $verify->created_at->diffInMinutes(now()) >= 3)){
            UserVerify::create([
                'user_id' => $user->id,
                'token' => $token
            ]);
            Mail::send('emails.verification', ['token' => $token], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Hesabınızı doğrulayın | ' . env('APP_NAME'));
            });
        }

        return redirect()->back()->with('code', 'success')->with('message', 'Doğrulama linki e-posta adresinize gönderildi.');
    }

    /**
     * Verify user account
     *
     * @param  mixed $token
     * @return void
     */
    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();

        if (!isset($verifyUser)) {
            return redirect()->route('login')->with(['message' => 'Geçersiz doğrulama bağlantısı.', 'code' => 'error']);
        }

        $user = User::find($verifyUser->user_id);
        $lastVerifyRequest = UserVerify::where('user_id', $user->id)->latest()->first();
        $message = 'Maalesef e-postanız tanımlanamıyor.';
        $code = 'error';
        // $verifyUser creation date exceeded 3 minutes
        if ($lastVerifyRequest == $verifyUser) {
            if ($lastVerifyRequest->created_at->diffInMinutes(now()) >= 3 && !$lastVerifyRequest->user->is_email_verified) {
                $message = 'E-posta doğrulama süresi doldu. Lütfen tekrar bağlantı gönderin.';
                $code = 'error';
            } else {
                if (!is_null($lastVerifyRequest)) {
                    $user = $lastVerifyRequest->user;
                    if (!$user->is_email_verified) {
                        $lastVerifyRequest->user->is_email_verified = 1;
                        $lastVerifyRequest->user->save();
                        $message = "E-postanız doğrulandı. Şimdi giriş yapabilirsiniz";
                        $code = 'success';

                        $data = [
                          'data' => $user->name
                        ];
                        Mail::send('emails.welcome-email', ["name"=>$data], function ($message) use ($user) {
                            $message->to($user->email);
                            $message->subject('Hoşgeldiniz | ' . env('APP_NAME'));
                        });

                    } else {
                        $message = "E-postanız zaten doğrulandı. Şimdi giriş yapabilirsiniz.";
                        $code = 'success';
                    }
                }
            }
        } else {
            $message = 'E-posta doğrulama süresi doldu. Lütfen tekrar giriş yapın ve bağlantı gönderin.';
            $code = 'error';
        }

        return redirect()->route('login', ['locale' => app()->getLocale()])->with(['message' => $message, 'code' => $code]);
    }

    /**
     * Change user email
     *
     * @param  mixed $token
     * @return void
     */
    public function changeEmail($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $user = User::find($verifyUser->user_id);
        $lastVerifyRequest = UserVerify::where('user_id', $user->id)->latest()->first();
        $code = 'error';
        $message = 'Maalesef e-postanız tanımlanamıyor.';
        if ($verifyUser == $lastVerifyRequest) {
            if ($lastVerifyRequest->created_at->diffInMinutes(now()) <= 3) {
                if ($lastVerifyRequest->new_email == $user->email) {
                    $code = 'error';
                    $message = 'E-posta adresiniz zaten bu e-posta adresiyle değiştirilmiş.';
                } else {
                    $user->email =  $lastVerifyRequest->new_email;
                    $user->save();
                    $code = 'success';
                    $message = 'E-posta adresiniz başarıyla değiştirildi.';
                }
            } else {
                $code = 'error';
                $message = 'E-posta değiştirme süresi doldu. Lütfen tekrar bağlantı gönderin.';
            }
        } else {
            $code = 'error';
            $message = 'Geçersiz bağlantı.';
        }

        return redirect()->route('changeEmail')->with(['response' => $message, 'code' => $code]);
    }
}
