<?php

namespace App\Http\Controllers;

use App\Data\MockData;

class AccountController
{
    public function profile()
    {
        $user = MockData::getUser();
        $cart = MockData::getCart();
        $cartCount = count($cart['items']);

        return view('account.profile', [
            'user' => $user,
            'cartCount' => $cartCount
        ]);
    }
}
