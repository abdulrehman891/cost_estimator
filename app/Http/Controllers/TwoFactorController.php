<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\SendTwoFactorCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
class TwoFactorController extends Controller
{
    //help document is https://medium.com/@laravelprotips/laravel-easy-two-factor-authentication-with-email-and-sms-1a362163a739
    public function index()
    {  
        return view('auth.twoFactor');
    }
    public function store(Request $request): ValidationException|RedirectResponse
    {
        $request->validate([
            'two_factor_code' => ['integer', 'required'],
        ]);
        $user = auth()->user();
        if ($request->input('two_factor_code') !== $user->two_factor_code) {
            throw ValidationException::withMessages([
                'two_factor_code' => __('The code you entered doesn\'t match our records'),
            ]);
        }
        $user->resetTwoFactorCode();
        return redirect()->to(RouteServiceProvider::HOME);
    }
    public function resend(): RedirectResponse
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new SendTwoFactorCode());
        return redirect()->back()->withStatus(__('Code has been sent again'));
    }
}
