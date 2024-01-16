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

class PaymentsContoller extends Controller
{
    public function doPackagePurchase(Request $request){
        $validated = $request->validate([
            'the_package' =>  [
                "required" ,
                "max:50", 
                Rule::In(['basic', 'advanced', 'professional'])
            ]
        ]);
        $identifier=$validated['the_package'];
        $packages = Packages::where('identifier','=',$identifier)->first();
        // echo "<pre>";
        // print_r($packages);
        // die;      
        $the_stripe_package_name=$packages->stripe_id;
        return $request->user()->newSubscription('Subscription',$the_stripe_package_name)
        //->allowPromotionCodes()
        ->checkout([
            'success_url' => route('pruchase_thankyou'),
            'cancel_url' => route('pruchase_failed'),
        ]);
    }
    public function Pruchase_Thankyou(Request $request){
        echo "Thanks";      
    }

    public function Pruchase_Failed(Request $request){
        echo "Failed";
    }

    public function Packages(){
        $packages = Packages::get();
        $user = Auth::user();
        return view('pages/apps.packages.list',compact('packages','user'));
    }

}
