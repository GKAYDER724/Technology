<?php

namespace App\Http\Controllers;

use App\Data\MockData;

class OrderController extends Controller
{
    public function index()
    {
        $orders = MockData::getOrders();
        $cart = MockData::getCart();
        $cartCount = count($cart['items']);

        $statusFilter = $_GET['status'] ?? 'all';
        if ($statusFilter !== 'all') {
            $orders = array_filter($orders, fn($o) => $o['status'] === $statusFilter);
        }

        return view('orders.index', [
            'orders' => array_values($orders),
            'currentStatus' => $statusFilter,
            'cartCount' => $cartCount
        ]);
    }

    public function show($id)
    {
        $orders = MockData::getOrders();
        $order = null;
        foreach ($orders as $o) {
            if ($o['id'] === $id) {
                $order = $o;
                break;
            }
        }

        if (!$order) {
            $order = $orders[0];
        }

        $cart = MockData::getCart();
        $cartCount = count($cart['items']);

        return view('orders.show', [
            'order' => $order,
            'cartCount' => $cartCount
        ]);
    }

    public function cancel($id)
    {
        $orders = MockData::getOrders();
        $order = null;
        foreach ($orders as $o) {
            if ($o['id'] === $id) {
                $order = $o;
                break;
            }
        }

        if (!$order) {
            $order = $orders[0];
        }

        $cart = MockData::getCart();
        $cartCount = count($cart['items']);

        return view('orders.cancel', [
            'order' => $order,
            'cartCount' => $cartCount
        ]);
    }
}
