<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Mailjet\Resources;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['send']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->to(app()->getLocale()."/login");
    }

    /**
     * Send email
     *
     * @param  mixed $request
     * @return void
     */
    public function send(Request $request)
    {
        $referer = $request->headers->get('referer');
        $urlParts = explode ('/', $referer);
        App::setLocale($urlParts[3]);
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ], [
            'name.required' => __('validation.name.required'),
            'email.required' => __('validation.email.required'),
            'message.required' => __('validation.message.required')
        ]);
        Contact::create($validateData);
        $customer_email = $validateData['email'];
        $customer_name = $validateData['name'];
        $textPart = $validateData['message'];
        $contact_message = new \Mailjet\Client(getenv('MAILJET_APIKEY'), getenv('MAILJET_APISECRET'), true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "info@marka.legal",
                        'Name' => "Takip marka legal",
                    ],
                    'To' => [
                        [
                            'Email' => "info@marka.legal",
                            'Name' => "Admin"
                        ]
                    ],
                    'Subject' => "New Contact Message",
                    'HTMLPart' => "Gelen yeni e-posta : " . $customer_email . "<br>" . "Müşteri Adı : " . $customer_name . "<br>" . "İleti : " . $textPart . "<br>",
                ]
            ]
        ];
        $response = $contact_message->post(Resources::$Email, ['body' => $body]);
        return redirect()->back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }

    /**
     * Change password
     *
     * @return void
     */
    public function showChangePasswordGet()
    {
        return view('dashboard.pages.settings.change-password');
    }

    /**
     * Change password Post
     *
     * @param  mixed $request
     * @return void
     */
    public function changePasswordPost(Request $request) {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Mevcut şifreniz şifre ile eşleşmiyor.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            // Current password and new password same
            return redirect()->back()->with("error","Yeni Şifre, mevcut şifrenizle aynı olamaz.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        return redirect()->back()->with("message","Şifre başarıyla değiştirildi!");
    }
    /**
     * Settings view
     *
     * @return void
     */
    public function settings(){
        return view('dashboard.pages.settings.settings-view');
    }

    /**
     * Change email view
     *
     * @return void
     */
    public function changeEmail(){
        return view('dashboard.pages.settings.change-email');
    }

    /**
     * Update user email
     *
     * @param  mixed $request
     * @return void
     */
    public function updateEmail(Request $request) {

        $request->validate([
            'email'=>'required|email|string|max:255|unique:users'
        ]);
        $user = Auth::user();
        $token = Str::random(64);

        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token,
            'new_email' => $request->email
        ]);

        $user->newEmail = $request->email;

        Mail::send('emails.change', ['token' => $token, 'user' => $user, 'newEmail' => $request->email], function ($message) use ($user) {
            $message->to($user->newEmail);
            $subject = trans('theme.emails.verification-email.subject');
            $message->subject($subject);
        });

        return back()->with('message','Onay mailiniz yeni e-posta adresinize gönderildi.');
    }
    /**
     * Show change name page
     *
     * @return void
     */
    public function changeName(){
        return view('dashboard.pages.settings.change-name');
    }

    /**
     * Update user name
     *
     * @param  mixed $request
     * @return void
     */
    public function updateName(Request $request){

        $request->validate([
            'name'=>'required|string|max:255'
        ]);
        $user =Auth::user();
        $user->name = $request['name'];
        $user->save();
        return back()->with('message','isim başarıyla güncellendi');
    }

    public function updateLanguage(Request $request){
        $languages = ['tr', 'en', 'es', 'it', 'de', 'ko', 'ja', 'fr'];
        if (!in_array($request->language, $languages)) {
            return response()->json([
                'message' => 'Language not found',
            ], 404);
        }

        $user = auth()->user();
        $user->language = $request->language;
        $user->save();

        return response()->json([
            'message' => 'User settings updated successfully',
            'new_language' => $user->language,
        ], 200);
    }
}
