<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Warung Pak Do</p>
            <h2 class="text-3xl font-bold text-slate-900">Selamat datang di Warung Pak Do</h2>
        </div>
    </x-slot>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 space-y-8">
        <div class="overflow-hidden rounded-[2rem] bg-gradient-to-br from-emerald-700 via-emerald-600 to-amber-400 p-8 text-white shadow-xl sm:p-10 lg:p-12">
            <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-emerald-100">Masakan rumahan, rasa istimewa</p>
                    <h1 class="mt-4 max-w-2xl text-4xl font-black leading-tight sm:text-5xl">Hangat, cepat, dan siap dipesan dari browser.</h1>
                    <p class="mt-4 max-w-2xl text-sm leading-7 text-emerald-50/90 sm:text-base">Pilih menu favorit, masukkan ke keranjang, lalu checkout tanpa ribet.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('products.index') }}" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-emerald-700">Pesan Sekarang</a>
                        @guest
                            <a href="{{ route('login') }}" class="rounded-full border border-white/40 px-5 py-3 text-sm font-semibold text-white">Login</a>
                        @endguest
                    </div>
                </div>
                <div class="grid gap-3 rounded-[1.75rem] bg-white/10 p-4 backdrop-blur">
                    <div class="rounded-2xl bg-white/15 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-100">Cepat</p>
                        <p class="mt-1 text-lg font-semibold">Tambah ke keranjang dalam 1 klik</p>
                    </div>
                    <div class="rounded-2xl bg-white/15 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-emerald-100">Aman</p>
                        <p class="mt-1 text-lg font-semibold">Checkout dengan COD atau transfer</p>
                    </div>
                </div>
            </div>
        </div>

        <section class="space-y-4">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Kategori</p>
                    <h3 class="text-2xl font-bold text-slate-900">Pilih sesuai selera</h3>
                </div>
                <a href="{{ route('products.index') }}" class="text-sm font-semibold text-emerald-700">Lihat semua</a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($categories as $category)
                    <a href="{{ route('products.category', $category) }}" class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-lg font-semibold text-slate-900">{{ $category->name }}</p>
                                <p class="mt-1 text-sm text-slate-500">Menu favorit pelanggan</p>
                            </div>
                            <div class="grid h-12 w-12 place-items-center rounded-2xl bg-emerald-50 text-emerald-700">✦</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="space-y-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Produk populer</p>
                <h3 class="text-2xl font-bold text-slate-900">Yang paling sering dipesan</h3>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                @foreach($featuredProducts as $product)
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x400/png?text=' . urlencode($product->name) }}" alt="{{ $product->name }}" class="h-44 w-full object-cover">
                        <div class="space-y-3 p-5">
                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">{{ $product->category?->name }}</span>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900">{{ $product->name }}</h4>
                                <p class="text-sm text-slate-500">{{ $product->formatted_price }}</p>
                            </div>
                            <a href="{{ route('products.show', $product) }}" class="inline-flex rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Lihat detail</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </section>
</x-app-layout>
