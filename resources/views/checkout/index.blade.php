<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Checkout</p>
            <h2 class="text-3xl font-bold text-slate-900">Lengkapi pesanan</h2>
        </div>
    </x-slot>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <form method="POST" action="{{ route('checkout.process') }}" class="space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm" x-data="{ deliveryMethod: '{{ old('delivery_method', 'ambil') }}' }">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Nama lengkap</label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}" required maxlength="100" autocomplete="name" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">
                        @error('customer_name')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Nomor WhatsApp</label>
                        <input type="tel" name="customer_phone" value="{{ old('customer_phone', $user->phone) }}" required maxlength="30" inputmode="tel" autocomplete="tel" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">
                        @error('customer_phone')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Metode pengiriman</label>
                    <select name="delivery_method" x-model="deliveryMethod" required class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="ambil" @selected(old('delivery_method') === 'ambil')>Ambil sendiri (gratis)</option>
                        <option value="antar" @selected(old('delivery_method') === 'antar')>Antar ke alamat (+Rp5.000)</option>
                    </select>
                    @error('delivery_method')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Alamat lengkap</label>
                    <textarea name="customer_address" rows="4" x-bind:required="deliveryMethod === 'antar'" maxlength="1000" autocomplete="street-address" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">{{ old('customer_address', $user->address) }}</textarea>
                    @error('customer_address')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                    <p class="mt-2 text-xs text-slate-500">Wajib jika memilih antar.</p>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Metode pembayaran</label>
                    <select name="payment_method" required class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="cod" @selected(old('payment_method') === 'cod')>COD</option>
                        <option value="transfer" @selected(old('payment_method') === 'transfer')>Transfer Bank</option>
                    </select>
                    @error('payment_method')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Catatan</label>
                    <textarea name="notes" rows="3" maxlength="1000" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">{{ old('notes') }}</textarea>
                </div>

                <div class="rounded-2xl bg-amber-50 p-4 text-sm text-amber-900">
                    <p class="font-semibold">Transfer Bank</p>
                    <p>BCA 1234567890 a.n. Warung Pak Do</p>
                </div>

                <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-5 py-4 font-semibold text-white hover:bg-emerald-700">Konfirmasi Pesanan</button>
            </form>

            <aside class="h-fit rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-bold text-slate-900">Ringkasan</h3>
                <div class="mt-5 space-y-4">
                    @foreach($items as $item)
                        <div class="flex justify-between gap-4 text-sm">
                            <div>
                                <p class="font-medium text-slate-900">{{ $item->product->name }}</p>
                                <p class="text-slate-500">{{ $item->quantity }}x {{ $item->variant_value ?: 'Standar' }}</p>
                            </div>
                            <p class="font-semibold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 space-y-2 border-t border-slate-100 pt-4">
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Ongkir</span>
                        <span>+Rp 5.000 jika antar</span>
                    </div>
                    <div class="flex justify-between text-base font-bold text-slate-900">
                        <span>Metode bayar</span>
                        <span>COD / Transfer</span>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-app-layout>
