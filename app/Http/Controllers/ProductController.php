<?php

namespace App\Http\Controllers;

use App\Data\MockData;

class ProductController
{
    public function index()
    {
        $categories = MockData::getCategories();
        $products = MockData::getProducts();
        $cart = MockData::getCart();
        $cartCount = count($cart['items']);

        // Check search or filter params
        $search = $_GET['search'] ?? '';
        $selectedCategory = $_GET['category'] ?? '';
        $selectedBrand = $_GET['brand'] ?? '';
        $sort = $_GET['sort'] ?? 'popular';

        $filteredProducts = $products;
        if ($search) {
            $filteredProducts = array_filter($filteredProducts, function ($p) use ($search) {
                return stripos($p['name'], $search) !== false || stripos($p['brand'], $search) !== false;
            });
        }
        if ($selectedCategory) {
            $filteredProducts = array_filter($filteredProducts, function ($p) use ($selectedCategory) {
                return $p['category'] === $selectedCategory;
            });
        }
        if ($selectedBrand) {
            $filteredProducts = array_filter($filteredProducts, function ($p) use ($selectedBrand) {
                return strcasecmp($p['brand'], $selectedBrand) === 0;
            });
        }

        if ($sort === 'price_asc') {
            usort($filteredProducts, fn($a, $b) => $a['price'] <=> $b['price']);
        } elseif ($sort === 'price_desc') {
            usort($filteredProducts, fn($a, $b) => $b['price'] <=> $a['price']);
        } elseif ($sort === 'rating') {
            usort($filteredProducts, fn($a, $b) => $b['rating'] <=> $a['rating']);
        }

        return view('products.index', [
            'categories' => $categories,
            'products' => array_values($filteredProducts),
            'totalCount' => count($filteredProducts),
            'search' => $search,
            'selectedCategory' => $selectedCategory,
            'selectedBrand' => $selectedBrand,
            'sort' => $sort,
            'cartCount' => $cartCount
        ]);
    }

    public function show($id)
    {
        $products = MockData::getProducts();
        $product = null;
        foreach ($products as $p) {
            if ($p['id'] == $id) {
                $product = $p;
                break;
            }
        }

        if (!$product) {
            $product = $products[0]; // fallback
        }

        $relatedProducts = array_filter($products, fn($p) => $p['id'] != $product['id']);
        $cart = MockData::getCart();
        $cartCount = count($cart['items']);

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => array_slice(array_values($relatedProducts), 0, 4),
            'cartCount' => $cartCount
        ]);
    }
}
