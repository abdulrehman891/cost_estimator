<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\SignatureVerificationException;
use Stripe\WebhookSignature;
use Stripe\Webhook;
use stripe;
use App\Models\User;
use Laravel\Cashier\Cashier;
use Exception;
use App\Models\Packages;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentsContoller extends Controller
{
    public function doPackagePurchase(Request $request)
    {
        $validated = $request->validate([
            'the_package' =>  [
                "required",
                "max:50",
                Rule::In(['basic', 'advanced', 'professional'])
            ]
        ]);
        $identifier = $validated['the_package'];
        $packages = Packages::where('identifier', '=', $identifier)->first();
        // echo "<pre>";
        // print_r($packages);
        // die;      
        $the_stripe_package_name = $packages->stripe_id;
        return $request->user()->newSubscription('Subscription', $the_stripe_package_name)
            //->allowPromotionCodes()
            ->checkout([
                'success_url' => route('quotation.list'),
                'cancel_url' => route('pruchase_failed'),
            ]);
    }
    public function Pruchase_Thankyou(Request $request)
    {
        echo "Thanks";
    }

    public function Pruchase_Failed(Request $request)
    {
        echo "Failed";
    }

    public function Packages()
    {
        $packages = Packages::get();
        $user = Auth::user();
        $packes_related_data = array();
        foreach ($packages as $package) {
            $packes_related_data["$package->identifier"] = array(
                $package->title, $package->price_usd, $package->validity_days
            );
        }
        $is_expired = false;
        if (!empty($user->subscription_ends_at)) {
            $expirationDate = Carbon::parse($user->subscription_ends_at);
            if (Carbon::now()->gt($expirationDate)) {
                $is_expired = true;
            }
            //get current plan name
            $package_stripe_id = $user->subscriptions()->get('stripe_price');
            $package = Packages::where('stripe_id', '=', $package_stripe_id[0]->stripe_price)->select('title')->first();
        }
        return view('pages/apps.packages.list', compact('packages', 'packes_related_data', 'user', 'is_expired','package'));
    }
}
