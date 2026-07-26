<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Detail Pesanan</p>
            <h2 class="text-3xl font-bold text-slate-900">{{ $order->order_number }}</h2>
        </div>
    </x-slot>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 space-y-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-slate-500">Status saat ini</p>
                    <span class="mt-2 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </div>
                @if($order->status === 'selesai' && $order->reviews->isNotEmpty())
                    <div class="rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        Ulasan sudah dikirim.
                    </div>
                @endif
                <div class="rounded-2xl bg-slate-50 px-4 py-3 text-right">
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Total</p>
                    <p class="text-2xl font-bold text-emerald-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <h3 class="font-semibold text-slate-900">Pengiriman</h3>
                    <p class="mt-2 text-sm text-slate-600">Metode: {{ $order->delivery_method === 'antar' ? 'Antar' : 'Ambil sendiri' }}</p>
                    <p class="text-sm text-slate-600">Telepon: {{ $order->phone }}</p>
                    @if($order->address)
                        <p class="text-sm text-slate-600">Alamat: {{ $order->address }}</p>
                    @endif
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <h3 class="font-semibold text-slate-900">Pembayaran</h3>
                    <p class="mt-2 text-sm text-slate-600">Metode: {{ $order->payment_method === 'transfer' ? 'Transfer bank' : 'COD' }}</p>
                    <p class="text-sm text-slate-600">Status: {{ ucfirst($order->payment_status) }}</p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-4">
                <h3 class="text-lg font-semibold text-slate-900">Item pesanan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">Varian</th>
                            <th class="px-6 py-4">Qty</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 font-semibold text-slate-900">{{ $item->product->name ?? 'Produk' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->variant_value ?: 'Standar' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-slate-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-900">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900">Timeline status</h3>
            <div class="mt-6 grid gap-4 md:grid-cols-3 xl:grid-cols-6">
                @foreach($timeline as $index => $status)
                    @php($active = $index <= $currentStatusIndex)
                    <div class="rounded-2xl border p-4 {{ $active ? 'border-emerald-200 bg-emerald-50' : 'border-slate-200 bg-slate-50' }}">
                        <div class="text-xs uppercase tracking-[0.2em] {{ $active ? 'text-emerald-700' : 'text-slate-500' }}">Step {{ $index + 1 }}</div>
                        <p class="mt-2 font-semibold {{ $active ? 'text-slate-900' : 'text-slate-600' }}">{{ $statusTimeline[$status] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        @if($order->status === 'selesai' && $order->reviews->isEmpty())
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Beri ulasan</h3>
                <form action="{{ route('reviews.store', $order) }}" method="POST" enctype="multipart/form-data" class="mt-5 space-y-4">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Rating</label>
                        <select name="rating" class="w-full rounded-2xl border-slate-200 px-4 py-3">
                            <option value="">Pilih rating</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} bintang</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Komentar</label>
                        <textarea name="comment" rows="4" class="w-full rounded-2xl border-slate-200 px-4 py-3"></textarea>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Foto (opsional)</label>
                        <input type="file" name="image" class="w-full rounded-2xl border border-slate-200 px-4 py-3">
                    </div>
                    <button type="submit" class="rounded-2xl bg-emerald-600 px-5 py-3 font-semibold text-white">Simpan ulasan</button>
                </form>
            </div>
        @endif
    </section>
</x-app-layout>
