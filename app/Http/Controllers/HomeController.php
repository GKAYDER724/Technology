<?php

namespace App\Http\Controllers;

use App\Data\MockData;

class HomeController
{
    public function index()
    {
        $categories = MockData::getCategories();
        $products = MockData::getProducts();
        $featured = array_filter($products, fn($p) => $p['is_featured']);
        $flashSales = array_filter($products, fn($p) => $p['discount'] >= 10);
        $cart = MockData::getCart();
        $cartCount = count($cart['items']);

        return view('home', [
            'categories' => $categories,
            'products' => $products,
            'featured' => $featured,
            'flashSales' => $flashSales,
            'cartCount' => $cartCount
        ]);
    }
}
