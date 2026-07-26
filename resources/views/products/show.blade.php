<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Detail Produk</p>
            <h2 class="text-3xl font-bold text-slate-900">{{ $product->name }}</h2>
        </div>
    </x-slot>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/1200x900/png?text=' . urlencode($product->name) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
            </div>

            <div class="space-y-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $product->category?->name }}</span>
                    <span class="text-sm text-slate-500">Stok {{ $product->stock }}</span>
                </div>

                <div>
                    <h1 class="text-3xl font-bold text-slate-900">{{ $product->name }}</h1>
                    <p class="mt-3 text-sm leading-7 text-slate-600">{{ $product->description }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Harga</p>
                    <p class="text-3xl font-bold text-emerald-700">{{ $product->formatted_price }}</p>
                </div>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4" x-data="{ qty: 1, variant: '{{ old('variant_value') }}' }">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Jumlah</label>
                            <div class="flex items-center gap-2 rounded-2xl border border-slate-200 p-2">
                                <button type="button" class="grid h-10 w-10 place-items-center rounded-xl bg-slate-100 text-lg" @click="qty = Math.max(1, qty - 1)">−</button>
                                <input type="number" min="1" max="10" name="quantity" x-model="qty" class="w-full border-0 text-center focus:ring-0">
                                <button type="button" class="grid h-10 w-10 place-items-center rounded-xl bg-slate-100 text-lg" @click="qty = Math.min(10, qty + 1)">+</button>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Varian</label>
                            <select name="variant_value" x-model="variant" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">Tanpa varian</option>
                                @foreach($product->variants as $variant)
                                    @foreach($variant->options as $option)
                                        <option value="{{ $option }}">{{ $variant->variant_name }}: {{ $option }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-5 py-4 font-semibold text-white hover:bg-emerald-700">
                        <span>Tambah ke Keranjang</span>
                    </button>
                </form>

                <div class="rounded-2xl border border-slate-200 p-4 text-sm text-slate-600">
                    <div class="flex items-center justify-between gap-3">
                        <p class="font-semibold text-slate-800">Review</p>
                        <p class="text-xs text-slate-500">{{ $product->reviews->count() }} ulasan</p>
                    </div>

                    @if($product->reviews->isNotEmpty())
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center gap-3 rounded-2xl bg-slate-50 p-3">
                                <div class="text-2xl font-bold text-emerald-700">{{ number_format($product->reviews->avg('rating'), 1) }}</div>
                                <div>
                                    <p class="font-semibold text-slate-900">Rating rata-rata</p>
                                    <p class="text-xs text-slate-500">Dari {{ $product->reviews->count() }} ulasan</p>
                                </div>
                            </div>

                            <div class="max-h-72 space-y-3 overflow-y-auto pr-1">
                                @foreach($product->reviews as $review)
                                    <article class="rounded-2xl border border-slate-200 p-3">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="font-semibold text-slate-900">{{ $review->user?->name ?? 'Pelanggan' }}</p>
                                            <p class="text-xs font-semibold text-amber-600">{{ $review->rating }}/5</p>
                                        </div>
                                        @if($review->comment)
                                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $review->comment }}</p>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="mt-1">Ulasan pelanggan akan tampil setelah pesanan selesai.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Deskripsi</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">{{ $product->description }}</p>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-slate-900">Produk Terkait</h3>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    @foreach($related as $relatedProduct)
                        <a href="{{ route('products.show', $relatedProduct) }}" class="group overflow-hidden rounded-2xl border border-slate-200 hover:shadow-md">
                            <img src="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : 'https://placehold.co/400x300/png?text=' . urlencode($relatedProduct->name) }}" alt="{{ $relatedProduct->name }}" class="h-32 w-full object-cover group-hover:scale-105 transition">
                            <div class="p-4">
                                <p class="font-semibold text-slate-900">{{ $relatedProduct->name }}</p>
                                <p class="text-sm text-emerald-700">{{ $relatedProduct->formatted_price }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
