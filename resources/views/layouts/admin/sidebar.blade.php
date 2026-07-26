<aside class="hidden lg:flex w-72 flex-col bg-slate-900 text-slate-100">
    <div class="border-b border-slate-800 p-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="grid h-10 w-10 place-items-center rounded-2xl bg-emerald-600 font-bold text-white">W</div>
            <div>
                <div class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-300">Warung Pak Do</div>
                <div class="text-xs text-slate-400">Admin Panel</div>
            </div>
        </a>
    </div>

    <nav class="flex-1 space-y-1 p-4">
        <a href="{{ route('admin.dashboard') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">Dashboard</a>
        <a href="{{ route('admin.categories.index') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">Kategori</a>
        <a href="{{ route('admin.products.index') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-emerald-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">Produk</a>
        <a href="{{ route('admin.orders.index') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">Pesanan</a>
        <a href="{{ route('admin.customers.index') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.customers.*') ? 'bg-emerald-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">Pelanggan</a>
        <a href="{{ route('admin.reports.index') }}" class="block rounded-2xl px-4 py-3 text-sm font-medium {{ request()->routeIs('admin.reports.*') ? 'bg-emerald-600 text-white' : 'text-slate-200 hover:bg-slate-800' }}">Laporan</a>
    </nav>

    <div class="border-t border-slate-800 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-2xl px-4 py-3 text-left text-sm font-medium text-rose-300 hover:bg-slate-800">Logout</button>
        </form>
    </div>
</aside>
