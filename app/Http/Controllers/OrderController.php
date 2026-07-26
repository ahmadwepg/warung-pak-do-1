<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->where('user_id', auth()->id())
            ->withCount('items')
            ->latest()
            ->paginate(12);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['items.product', 'reviews']);

        return view('orders.show', [
            'order' => $order,
            'timeline' => array_keys($order->timeline),
            'statusTimeline' => $order->timeline,
            'currentStatusIndex' => array_search($order->status, array_keys($order->timeline), true),
        ]);
    }
}
