<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    // Chuyển sang Google đăng nhập
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }


    // Google callback
    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();


        $user = User::updateOrCreate(
            [
                'email' => $googleUser->getEmail(),
            ],
            [
                'fullname' => $googleUser->getName(),
                'password' => bcrypt(str()->random(16)),
                'status' => 'active',
                'role_id' => 3,
            ]
        );


        Auth::login($user);


        return redirect('/');
    }
}