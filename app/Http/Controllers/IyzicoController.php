<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IyzicoController extends Controller
{
    public $options;

    public function __construct()
    {
        $this->options = new \Iyzipay\Options();
        $this->options->setApiKey("sandbox-wNUcBxbnJcGrWmwLJFyvmU0L4yZQ1qR1");
        $this->options->setSecretKey("sandbox-YhpZmgue4PdEHNOiwDJCzZpKEVvSpJvF");
        $this->options->setBaseUrl("https://sandbox-api.iyzipay.com");
    }
    public function createProduct()
    {
        // Create Temel Plan
        $product = new \Iyzipay\Request\Subscription\SubscriptionCreateProductRequest();
        $product->setLocale("tr");
        $product->setName("Takip subscription");
        $product = \Iyzipay\Model\Subscription\SubscriptionProduct::create($product,$this->options);
    }

    public function createPlans()
    {
        $request = new \Iyzipay\Request\Subscription\SubscriptionListProductsRequest();
        $request->setPage(1);
        $request->setCount(10);
        $result = \Iyzipay\Model\Subscription\RetrieveList::products($request,$this->options);

        $product_reference_code = $result->getItems()[0]->referenceCode;

        // Create temel plan
        $request_temel_plan = new \Iyzipay\Request\Subscription\SubscriptionCreatePricingPlanRequest();
        $request_temel_plan->setLocale('tr');
        $request_temel_plan->setProductReferenceCode("$product_reference_code");
        $request_temel_plan->setName('Temel Plan');
        $request_temel_plan->setPrice('235.00');
        $request_temel_plan->setCurrencyCode('TRY');
        $request_temel_plan->setPaymentInterval('MONTHLY');
        $request_temel_plan->setPaymentIntervalCount(1);
        $request_temel_plan->setPlanPaymentType('RECURRING');
        $result = \Iyzipay\Model\Subscription\SubscriptionPricingPlan::create($request_temel_plan,$this->options);

        // Create Professoynel plan
        $request_profesyonel_plan = new \Iyzipay\Request\Subscription\SubscriptionCreatePricingPlanRequest();
        $request_profesyonel_plan->setLocale('tr');
        $request_profesyonel_plan->setProductReferenceCode("$product_reference_code");
        $request_profesyonel_plan->setName('Profesyonel Plan');
        $request_profesyonel_plan->setPrice('585.00');
        $request_profesyonel_plan->setCurrencyCode('TRY');
        $request_profesyonel_plan->setPaymentInterval('MONTHLY');
        $request_profesyonel_plan->setPaymentIntervalCount(1);
        $request_profesyonel_plan->setPlanPaymentType('RECURRING');
        $result = \Iyzipay\Model\Subscription\SubscriptionPricingPlan::create($request_profesyonel_plan,$this->options);

        // Create premium plan
        $request_premium_plan = new \Iyzipay\Request\Subscription\SubscriptionCreatePricingPlanRequest();
        $request_premium_plan->setLocale('tr');
        $request_premium_plan->setProductReferenceCode("$product_reference_code");
        $request_premium_plan->setName('Premium Plan');
        $request_premium_plan->setPrice('820.00');
        $request_premium_plan->setCurrencyCode('TRY');
        $request_premium_plan->setPaymentInterval('MONTHLY');
        $request_premium_plan->setPaymentIntervalCount(1);
        $request_premium_plan->setPlanPaymentType('RECURRING');
        $result = \Iyzipay\Model\Subscription\SubscriptionPricingPlan::create($request_premium_plan,$this->options);
    }

    public function createCustomers()
    {

    }
}
