<?php

namespace App\Http\Controllers;

use App\Data\MockData;

class NotificationController
{
    public function index()
    {
        $notifications = MockData::getNotifications();
        $cart = MockData::getCart();
        $cartCount = count($cart['items']);

        $filter = $_GET['filter'] ?? 'all';
        if ($filter !== 'all') {
            $notifications = array_filter($notifications, fn($n) => $n['type'] === $filter);
        }

        return view('notifications.index', [
            'notifications' => array_values($notifications),
            'currentFilter' => $filter,
            'cartCount' => $cartCount
        ]);
    }
}
