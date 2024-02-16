<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class CheckCompanyProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the current route is not 'company-profile.show'
        if (Route::currentRouteName() !== 'company-profile.show') {
            if (empty(auth()->user()->companyProfile->signnow_brand_id)) {
                //redirect to company profile page so that a user may not proceed in the system
                return redirect()->route('company-profile.show');
            }
        }
        return $next($request);
    }
}
