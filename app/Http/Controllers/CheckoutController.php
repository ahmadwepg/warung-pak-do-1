<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = auth()->user()->cart()->with(['items.product.category'])->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang masih kosong.');
        }

        return view('checkout.index', [
            'items' => $cart->items,
            'subtotal' => $cart->items->sum('subtotal'),
            'user' => auth()->user(),
        ]);
    }

    public function process(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'customer_address' => ['nullable', 'string', 'max:1000'],
            'delivery_method' => ['required', 'in:antar,ambil'],
            'payment_method' => ['required', 'in:transfer,cod'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($data['delivery_method'] === 'antar' && blank($data['customer_address'])) {
            return back()->withErrors(['customer_address' => 'Alamat wajib diisi untuk pengantaran.'])->withInput();
        }

        $cart = auth()->user()->cart()->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang masih kosong.');
        }

        $order = DB::transaction(function () use ($cart, $data) {
            $items = $cart->items()->with('product')->get();

            foreach ($items as $item) {
                if ($item->product && $item->quantity > $item->product->stock) {
                    abort(422, 'Stok produk tidak cukup: '.$item->product->name);
                }
            }

            $subtotal = $items->sum('subtotal');
            $deliveryFee = $data['delivery_method'] === 'antar' ? 5000 : 0;
            $total = $subtotal + $deliveryFee;

            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'total_price' => $total,
                'delivery_method' => $data['delivery_method'],
                'address' => $data['customer_address'] ?? null,
                'phone' => $data['customer_phone'],
                'payment_method' => $data['payment_method'],
                'payment_status' => 'pending',
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'variant_value' => $item->variant_value,
                    'quantity' => $item->quantity,
                    'price' => $item->product?->price ?? 0,
                ]);

                Product::whereKey($item->product_id)->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat.');
    }
}
