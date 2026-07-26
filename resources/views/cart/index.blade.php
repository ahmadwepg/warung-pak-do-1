<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Keranjang</p>
            <h2 class="text-3xl font-bold text-slate-900">Pesananmu siap dirapikan</h2>
        </div>
    </x-slot>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @if($cart->items->isNotEmpty())
            <div class="grid gap-6 lg:grid-cols-[1fr_340px]">
                <div class="space-y-4">
                    @foreach($cart->items as $item)
                        <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="flex gap-4">
                                <img src="{{ $item->image_url }}" alt="{{ $item->product->name }}" class="h-24 w-24 rounded-2xl object-cover">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-slate-900">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-slate-500">{{ $item->variant_value ?: 'Tanpa varian' }}</p>
                                        </div>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-semibold text-rose-600">Hapus</button>
                                        </form>
                                    </div>

                                    <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                                        <div>
                                            <p class="text-sm text-slate-500">Harga</p>
                                            <p class="font-semibold text-slate-900">{{ $item->product->formatted_price }}</p>
                                        </div>
                                        <div>
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" name="quantity" value="{{ max(0, $item->quantity - 1) }}" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200">−</button>
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" max="10" class="w-20 rounded-xl border-slate-200 text-center">
                                                <button type="submit" name="quantity" value="{{ min(10, $item->quantity + 1) }}" class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200">+</button>
                                                <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Update</button>
                                            </form>
                                        </div>
                                        <div>
                                            <p class="text-sm text-slate-500">Subtotal</p>
                                            <p class="font-semibold text-emerald-700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <aside class="h-fit rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-bold text-slate-900">Ringkasan</h3>
                    <div class="mt-5 space-y-3 text-sm text-slate-600">
                        <div class="flex justify-between">
                            <span>Item</span>
                            <span>{{ $cart->items->count() }}</span>
                        </div>
                        <div class="flex justify-between border-t border-slate-100 pt-3 text-base font-semibold text-slate-900">
                            <span>Total</span>
                            <span>Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="mt-6 flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-4 py-3 font-semibold text-white hover:bg-emerald-700">Lanjut ke Checkout</a>
                </aside>
            </div>
        @else
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-8 py-16 text-center shadow-sm">
                <h3 class="text-2xl font-bold text-slate-900">Keranjang masih kosong</h3>
                <p class="mt-3 text-slate-600">Yuk pilih menu favoritmu dulu.</p>
                <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-2xl bg-emerald-600 px-5 py-3 font-semibold text-white">Lihat Menu</a>
            </div>
        @endif
    </section>
</x-app-layout>
