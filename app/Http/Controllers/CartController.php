<?php

namespace App\Http\Controllers;

use App\Data\MockData;

class CartController extends Controller
{
    public function index()
    {
        $cart = MockData::getCart();
        $products = MockData::getProducts();
        $cartCount = count($cart['items']);

        $subtotal = 0;
        foreach ($cart['items'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $discount = $cart['discount'];
        $shipping = $cart['shipping'];
        $total = max(0, $subtotal - $discount + $shipping);

        $suggestedItems = array_slice($products, 2, 3);

        return view('cart', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total' => $total,
            'cartCount' => $cartCount,
            'suggestedItems' => $suggestedItems
        ]);
    }

    public function checkout()
    {
        $cart = MockData::getCart();
        $user = MockData::getUser();
        $cartCount = count($cart['items']);

        $subtotal = 0;
        foreach ($cart['items'] as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $discount = $cart['discount'];
        $shipping = 0;
        $total = max(0, $subtotal - $discount + $shipping);

        return view('checkout', [
            'cart' => $cart,
            'user' => $user,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total' => $total,
            'cartCount' => $cartCount
        ]);
    }
}
