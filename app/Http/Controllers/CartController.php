<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = $this->cartForUser()->load(['items.product.category']);

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:10'],
            'variant_value' => ['nullable', 'string', 'max:100'],
        ]);

        if ($product->stock <= 0) {
            return back()->with('error', 'Stok produk habis.');
        }

        $quantity = min((int) ($data['quantity'] ?? 1), $product->stock, 10);
        $variantValue = $data['variant_value'] ?? null;

        $cart = $this->cartForUser();
        $item = $cart->items()->firstOrNew([
            'product_id' => $product->id,
            'variant_value' => $variantValue,
        ]);

        $item->quantity = min(10, ((int) $item->quantity ?: 0) + $quantity);
        $item->save();

        return redirect()->route('cart.index')->with('success', $product->name.' ditambahkan ke keranjang.');
    }

    public function updateQty(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->cart->user_id === auth()->id(), 403);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        if ($data['quantity'] <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->quantity = min(10, $data['quantity']);
            $cartItem->save();
        }

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->cart->user_id === auth()->id(), 403);

        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function count(): int
    {
        return $this->cartForUser()->items()->count();
    }

    private function cartForUser(): Cart
    {
        return auth()->user()->cart()->firstOrCreate([]);
    }
}
