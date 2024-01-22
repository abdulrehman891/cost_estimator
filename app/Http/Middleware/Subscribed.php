<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Packages;
use App\Models\User;
use Illuminate\Support\Carbon;
class Subscribed
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check if the person subscription period is ended, then redirect him to the packages page
        $user = $request->user();
        if (empty($user->subscription_ends_at) || Carbon::now()->gt($user->subscription_ends_at)){
            //Redirect user to packages page and ask them to subscribe...
            return redirect('/packages');
        }
        /*
        $packages = Packages::pluck('stripe_id')->toArray();
        if (!$request->user()->subscribedToPrice($packages,'Subscription')) {
            return redirect('/packages');
        }
        if (! $request->user()?->subscribed()) {
            // Redirect user to packages page and ask them to subscribe...
            return redirect('/packages');
        }
        */
        return $next($request);
    }
}