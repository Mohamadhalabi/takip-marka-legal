<?php

namespace App\Http\Controllers;

use App\Classes\TrademarkSearch;
use App\Jobs\SendReportMail;
use App\Models\Bulletin;
use App\Models\Contact;
use App\Models\Keyword;
use App\Models\Media;
use App\Models\Order;
use App\Models\Plan;
use App\Models\Report;
use App\Models\TestLimit;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Iyzipay\Model\Subscription\RetrieveSubscriptionCheckoutForm;
use Iyzipay\Model\Subscription\SubscriptionProduct;
use Mailjet\Resources;

class SubscriptionController extends Controller
{
    public $options;

    public function __construct()
    {
        $this->options = new \Iyzipay\Options();
        $this->options->setApiKey("sandbox-wNUcBxbnJcGrWmwLJFyvmU0L4yZQ1qR1");
        $this->options->setSecretKey("sandbox-YhpZmgue4PdEHNOiwDJCzZpKEVvSpJvF");
        $this->options->setBaseUrl("https://sandbox-api.iyzipay.com");
    }

    /**
     * Subscribe email to newsletter
     *
     * @return void
     */
    public function subscribe()
    {
        $update = User::where('id', auth()->user()->id)
            ->update([
                'subscription' => 1,
            ]);
        if ($update) {
            return response()->json([
                'statusCode' => 200
            ]);
        }
    }
    /**
     * Unsubscribe email to newsletter
     *
     * @return void
     */
    public function unsubscribe()
    {
        $update = User::where('id', auth()->user()->id)
            ->update([
                'subscription' => 0,
            ]);
        if ($update) {
            return response()->json([
                'statusCode' => 200
            ]);
        }
    }

    public function createOrder(Request $request,$name,$is_downgrade)
    {


        $order = new Order;

        $plan = Plan::where('plan_name', $name)->first();

        $plan_id = $plan->id;

        $user_keywords_counter = Keyword::where('user_id',Auth::user()->id)->count();

        $plan_keyword_limit = $plan->keyword_limit;

        //get plan_price
        $plan_price = $plan->price;




        if(Auth::user()->plan_id > $plan_id && $request->accept_downgrade == "false"){
            return response()->json([
                'show_downgrade_modal' => 200,
                'user_keywords_counter' => $user_keywords_counter,
                'plan_keyword_limit' => $plan_keyword_limit
            ]);
        }


        //generate order reference
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = str_shuffle($characters);
        $generatedString = substr($randomString, 0, 6);

        //store order in database
        $order->name = Auth::user()->name;
        $order->user_id = Auth::user()->id;
        $order->email = Auth::user()->email;
        $order->amount = $plan_price;
        $order->plan_id = $plan_id;
        $order->uuid = (string) Str::uuid();
        $order->order_ref = $generatedString;
        $order->save();

        $options = new \Iyzipay\Options();
        $options->setApiKey("sandbox-wNUcBxbnJcGrWmwLJFyvmU0L4yZQ1qR1");
        $options->setSecretKey("sandbox-YhpZmgue4PdEHNOiwDJCzZpKEVvSpJvF");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");


        // list available products
        $request = new \Iyzipay\Request\Subscription\SubscriptionListProductsRequest();
        $request->setPage(1);
        $request->setCount(10);
        $result = \Iyzipay\Model\Subscription\RetrieveList::products($request,$this->options);
        $product_reference_code = $result->getItems()[0]->referenceCode;

        //list plans that belong to the product
        $request = new \Iyzipay\Request\Subscription\SubscriptionListPricingPlanRequest();
        $request->setPage(1);
        $request->setCount(3);
        $request->setProductReferenceCode("$product_reference_code");
        $result = \Iyzipay\Model\Subscription\RetrieveList::pricingPlan($request,$this->options);


        $list_plans = $result->getItems();

        foreach ($list_plans as $list_plan)
        {
            if($list_plan->name === $name){
                $pricing_plan_reference_code = $list_plan->referenceCode;
            }
        }

        $customer_name = Auth::user()->name;
        $customer_email = Auth::user()->email;

        if (strpos($customer_name, ' ') !== false) {
            $customer_surname = substr($customer_name, strpos($customer_name, ' ') + 1);
        }
        else{
            $customer_surname = "---";
        }


        //create customer
        $request = new \Iyzipay\Request\Subscription\SubscriptionCreateCustomerRequest();
        $request->setLocale("tr");
        $customer = new \Iyzipay\Model\Customer();
        $customer->setName("$customer_name");
        $customer->setSurname("$customer_surname");
        $customer->setGsmNumber("+905555555555");
        $customer->setEmail("$customer_email");
        $customer->setIdentityNumber("11111111111");
        $customer->setShippingContactName("$customer_name");
        $customer->setShippingCity("Istanbul");
        $customer->setShippingDistrict("altunizade");
        $customer->setShippingCountry("Turkey");
        $customer->setShippingAddress("Uskudar Burhaniye Mahallesi iyzico A.S");
        $customer->setShippingZipCode("34660");
        $customer->setBillingContactName("$customer_name");
        $customer->setBillingCity("Istanbul");
        $customer->setBillingDistrict("altunizade");
        $customer->setBillingCountry("Turkey");
        $customer->setBillingAddress("Uskudar Burhaniye Mahallesi iyzico A.S");
        $customer->setBillingZipCode("34660");
        $request->setCustomer($customer);
        $result = \Iyzipay\Model\Subscription\SubscriptionCustomer::create($request,$this->options);


        //Create subscription
        $request = new \Iyzipay\Request\Subscription\SubscriptionCreateCheckoutFormRequest();
        $request->setLocale("tr");
        $request->setPricingPlanReferenceCode("$pricing_plan_reference_code");
        $request->setSubscriptionInitialStatus("ACTIVE");
        $request->setCallbackUrl(route('iyzico.callback', ['uuid' => $order->uuid,'name'=> $name, 'is_downgrade' => $is_downgrade]));

        $customer = new \Iyzipay\Model\Customer();
        $customer->setName("$customer_name");
        $customer->setSurname("$customer_surname");
        $customer->setGsmNumber("+905555555555");
        $customer->setEmail("$customer_email");
        $customer->setIdentityNumber("11111111111");
        $customer->setShippingContactName("$customer_name");
        $customer->setShippingCity("Istanbul");
        $customer->setShippingCountry("Turkey");
        $customer->setShippingAddress("Uskudar Burhaniye Mahallesi iyzico A.S");
        $customer->setShippingZipCode("34660");
        $customer->setBillingContactName("$customer_name");
        $customer->setBillingCity("Istanbul");
        $customer->setBillingCountry("Turkey");
        $customer->setBillingAddress("Uskudar Burhaniye Mahallesi iyzico A.S");
        $customer->setBillingZipCode("34660");
        $request->setCustomer($customer);

        $result = \Iyzipay\Model\Subscription\SubscriptionCreateCheckoutForm::create($request, $this->options);

        $form = $result->getCheckoutFormContent();
        $token = $result->getToken();

        Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->update(['token' => $token]);

        return view('dashboard.pages.subscription.iyzico-form')
            ->with('form', $form);
    }

    public function plans()
    {
        return view('dashboard.pages.subscription.index');
    }

    public function callback(Request $request)
    {

        $is_downgrade = $request->is_downgrade;
        // list available products
        $req = new \Iyzipay\Request\Subscription\SubscriptionListProductsRequest();
        $req->setPage(1);
        $req->setCount(10);
        $result = \Iyzipay\Model\Subscription\RetrieveList::products($req,$this->options);
        $product_reference_code = $result->getItems()[0]->referenceCode;

        //list plans that belong to the product
        $req = new \Iyzipay\Request\Subscription\SubscriptionListPricingPlanRequest();
        $req->setPage(1);
        $req->setCount(3);
        $req->setProductReferenceCode("$product_reference_code");
        $result = \Iyzipay\Model\Subscription\RetrieveList::pricingPlan($req,$this->options);


        $list_plans = $result->getItems();

        foreach ($list_plans as $list_plan)
        {
            if($list_plan->name === $request->name){
                $pricing_plan_reference_code = $list_plan->referenceCode;
            }
        }
        $req = new \Iyzipay\Request\Subscription\SubscriptionListCustomersRequest();
        $req->setPage(1);
        $req->setCount(100);
        $result = \Iyzipay\Model\Subscription\RetrieveList::customers($req,$this->options);
        $customers = $result->getItems();

        foreach ($customers as $customer)
        {
            if ($customer->email === Auth::user()->email) {
                $customer_reference_code = $customer->referenceCode;
            }
        }

        //retrieve customer
        $req = new \Iyzipay\Request\Subscription\SubscriptionSearchRequest();
        $req->setPage(1);
        $req->setCount(10);
        $req->setSubscriptionStatus('ACTIVE');
        $req->setCustomerReferenceCode("$customer_reference_code");
        $result = \Iyzipay\Model\Subscription\RetrieveList::subscriptions($req,$this->options);

        $subscription_details = $result->getItems();

        if(isset($subscription_details[1])) {
            if (count($subscription_details) === 2) {
                if ($subscription_details[1]->subscriptionStatus == "ACTIVE") {
                    $subscription_reference_code = $subscription_details[1]->referenceCode;
                    $subscription_reference_codee = $subscription_details[0]->referenceCode;

                    //downgrade subscription
                    if($is_downgrade =="true") {


                        $req = new \Iyzipay\Request\Subscription\SubscriptionCancelRequest();
                        $req->setLocale("tr");
                        $req->setSubscriptionReferenceCode("$subscription_reference_codee");
                        $result = \Iyzipay\Model\Subscription\SubscriptionCancel::cancel($req, $this->options);


                        $req = new \Iyzipay\Request\Subscription\SubscriptionUpgradeRequest();
                        $req->setLocale("TR");
                        $req->setSubscriptionReferenceCode("$subscription_reference_code");
                        $req->setNewPricingPlanReferenceCode("$pricing_plan_reference_code");
                        $req->setUpgradePeriod("NEXT_PERIOD");
                        $req->setUseTrial(true);
                        $req->setResetRecurrenceCount(true);
                        $result = \Iyzipay\Model\Subscription\SubscriptionUpgrade::update($req, $this->options);

                    }

                    // cancel old subscription upgrade subscription
                    else if($is_downgrade == "false") {
                        $req = new \Iyzipay\Request\Subscription\SubscriptionCancelRequest();
                        $req->setLocale("tr");
                        $req->setSubscriptionReferenceCode("$subscription_reference_code");
                        $result = \Iyzipay\Model\Subscription\SubscriptionCancel::cancel($req, $this->options);
                    }
                }
            }
        }


        $order = Order::where('uuid',$request->uuid)->first();
        $token = $order->token;
        $reference = $order->order_ref;

        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setToken("$token");
        $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $this->options);

        $user = User::find($order->user_id);

        if ($checkoutForm->getPaymentStatus() == "SUCCESS") {
            Order::where('token', $token)->update(['order_status' => "success"]);

            $order_plan = $order->plan_id;
            $plan_limits = Plan::where('id', $order_plan)->first();

            if ($is_downgrade == "false") {
                // After a successfull plan upgrade
                // update user limits
                $user->plan_id = $order_plan;
                $user->keyword_limit = $plan_limits->keyword_limit;
                $user->landscape_limit = $plan_limits->landscape_limit;
                $user->remaining_landscape_search_limit = $plan_limits->landscape_limit;
                $user->search_limit = $plan_limits->search_limit;
                $user->remaining_bulletin_search_limit = $plan_limits->search_limit;
                $user->subscription_ends_on = Carbon::now()->addDays(30)->toDateString();
                $user->save();
            }
            else if ($is_downgrade =="true") {
                //change the plan_id only
                $user->plan_id = $order_plan;
                $user->save();
            }
            $user_name = $user->name;
            $subscription_ends_on = $user->subscription_ends_on;
            $plan_name = $plan_limits->plan_name;
            $amount = $plan_limits->price;
            $current_date = Carbon::now()->toDateTimeString();

            // send an email after successfull upgrade / downgrade
            Mail::send('emails.new-subscription', compact('user_name', 'plan_name', 'current_date', 'amount'), function ($message) use ($user) {
                $message->to($user->email)
                    ->bcc("info@marka.legal")
                    ->subject("Yeni Abonelik planı - " . env('APP_NAME'));
            });

            return view('dashboard.pages.subscription.payment-successful', compact('user_name', 'subscription_ends_on', 'amount', 'plan_name', 'reference'));
        }
    }
    public function manageSub()
    {
        $user = Auth::user()->plan_id;
        $sub_ends_on = Auth::user()->subscription_ends_on;
        $plan_name = Plan::where('id',$user)->first()->plan_name;
        return view('dashboard.pages.settings.manage-subscription',compact('plan_name','sub_ends_on'));
    }
    public function cancelSubscription()
    {

        $req = new \Iyzipay\Request\Subscription\SubscriptionListCustomersRequest();
        $req->setPage(1);
        $req->setCount(100);
        $result = \Iyzipay\Model\Subscription\RetrieveList::customers($req,$this->options);
        $customers = $result->getItems();

        foreach ($customers as $customer)
        {
            if ($customer->email === Auth::user()->email) {
                $customer_reference_code = $customer->referenceCode;
            }
        }

        //retrieve customer
        $req = new \Iyzipay\Request\Subscription\SubscriptionSearchRequest();
        $req->setPage(1);
        $req->setCount(10);
        $req->setSubscriptionStatus('ACTIVE');
        $req->setCustomerReferenceCode("$customer_reference_code");
        $result = \Iyzipay\Model\Subscription\RetrieveList::subscriptions($req,$this->options);

        $subscription_details = $result->getItems();

        if($subscription_details !=[]) {
            $subscription_reference_code = $subscription_details[0]->referenceCode;
            $req = new \Iyzipay\Request\Subscription\SubscriptionCancelRequest();
            $req->setLocale("tr");
            $req->setSubscriptionReferenceCode("$subscription_reference_code");
            $result = \Iyzipay\Model\Subscription\SubscriptionCancel::cancel($req, $this->options);
        }
        if(User::where('id', auth()->user()->id)->first()->plan_id !=1) {
            $update = User::where('id', auth()->user()->id)
                ->update([
                    'plan_id' => 1,
                ]);
            if ($update) {
                return response()->json([
                    'statusCode' => 200
                ]);
            }
        }
    }

    public function sendEmail(Request $request)
    {

        $validateData = $request->validate(
            [
                'subject' => 'required',
                'recipient_email' => 'required|email',
                'message' => 'required'
            ],
            [
                'name.required' => 'Lütfen Adınızı giriniz',
                'email.required' => 'Lütfen E-postanızı giriniz',
                'message.required' => 'Lütfen Mesajınız giriniz'
            ]
        );
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

    public function locked()
    {
        return view('dashboard.pages.subscription.locked');
    }
}
