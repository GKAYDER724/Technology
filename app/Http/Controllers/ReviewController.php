<?php

namespace App\Http\Controllers;

use App\Data\MockData;

class ReviewController
{
    public function index()
    {
        $reviews = MockData::getReviews();
        $cart = MockData::getCart();
        $cartCount = count($cart['items']);

        return view('reviews.index', [
            'pendingReviews' => $reviews['pending'],
            'submittedReviews' => $reviews['submitted'],
            'cartCount' => $cartCount
        ]);
    }
}
