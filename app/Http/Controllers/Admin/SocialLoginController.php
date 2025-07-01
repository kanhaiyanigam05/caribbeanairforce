<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            $name = $socialUser->getName();
            $nameParts = explode(' ', $name, 2);
            // Find or create a user based on provider details
            $user = User::updateOrCreate([
                'email' => $socialUser->getEmail(),
            ], [
                'fname' => $nameParts[0] ?? null,
                'lname' => $nameParts[1] ?? null,
                'provider_id' => $socialUser->getId(),
                'provider' => $provider,
            ]);

            // Log the user in
            Auth::login($user);

            return redirect()->intended('/home');
        } catch (Exception $e) {
            return redirect('/login')->withErrors(['login_error' => 'Failed to login with ' . $provider]);
        }
    }
}
