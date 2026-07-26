<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Katalog Menu</p>
            <h2 class="text-3xl font-bold text-slate-900">Pilih menu favoritmu</h2>
            <p class="max-w-2xl text-sm text-slate-600">Cari, filter kategori, lalu tambah ke keranjang dengan satu klik.</p>
        </div>
    </x-slot>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-[280px_1fr]">
            <aside class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <form method="GET" action="{{ route('products.index') }}" class="space-y-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Cari menu</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nasi goreng, ayam, minuman..." class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Kategori</label>
                        <select name="category" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">Semua kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white hover:bg-emerald-700">Terapkan</button>
                        <a href="{{ route('products.index') }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">Reset</a>
                    </div>
                </form>
            </aside>

            <div class="space-y-5">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-600">{{ $products->total() }} menu ditemukan</p>
                    @if(isset($category))
                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">Kategori: {{ $category->name }}</span>
                    @endif
                </div>

                <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse($products as $product)
                        <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <a href="{{ route('products.show', $product) }}">
                                <img src="{{ $product->image ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/' . $product->image)) : 'https://placehold.co/600x400/png?text=' . urlencode($product->name) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover">
                            </a>
                            <div class="space-y-3 p-5">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $product->category?->name }}</span>
                                    @if($product->variants->isNotEmpty())
                                        <span class="text-xs text-slate-500">Ada varian</span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                                    <p class="mt-1 line-clamp-2 text-sm text-slate-600">{{ $product->description }}</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-lg font-bold text-emerald-700">{{ $product->formatted_price }}</p>
                                        <p class="text-xs text-slate-500">Stok {{ $product->stock }}</p>
                                    </div>
                                    <a href="{{ route('products.show', $product) }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Detail</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500">
                            Menu tidak ditemukan.
                        </div>
                    @endforelse
                </div>

                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
