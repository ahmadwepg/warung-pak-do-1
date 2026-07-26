<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('user', 'items.product', 'reviews.user');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:diterima,disiapkan,dikirim,selesai,dibatalkan'],
        ]);

        $validFlow = [
            'pending' => ['diterima', 'dibatalkan'],
            'diterima' => ['disiapkan', 'dibatalkan'],
            'disiapkan' => ['dikirim', 'dibatalkan'],
            'dikirim' => ['selesai', 'dibatalkan'],
        ];

        $newStatus = $data['status'];
        $currentStatus = $order->status;

        if (! isset($validFlow[$currentStatus]) || ! in_array($newStatus, $validFlow[$currentStatus], true)) {
            return back()->with('error', 'Transisi status tidak valid. Status saat ini: '.$currentStatus);
        }

        $order->update([
            'status' => $newStatus,
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi '.ucfirst($newStatus));
    }
}
