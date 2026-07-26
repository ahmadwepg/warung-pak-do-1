<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->user_id === auth()->id(), 403);
        abort_unless($order->status === 'selesai', 403);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($order->reviews()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'Kamu sudah memberi ulasan untuk pesanan ini.');
        }

        $firstItem = $order->items()->first();

        $payload = [
            'user_id' => auth()->id(),
            'product_id' => $firstItem->product_id,
            'order_id' => $order->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'image' => null,
        ];

        if ($request->hasFile('image')) {
            $payload['image'] = $request->file('image')->store('reviews', 'public');
        }

        Review::create($payload);

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }
}
