<nav x-data="{ open: false }" class="border-b border-emerald-100 bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-10">
            <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}" class="flex items-center gap-3">
                <div class="grid h-10 w-10 place-items-center rounded-2xl bg-emerald-600 text-white font-bold">W</div>
                <div>
                    <div class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-700">Warung Pak Do</div>
                    <div class="text-xs text-slate-500">Masakan rumahan</div>
                </div>
            </a>

            <div class="hidden items-center gap-2 md:flex">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Beranda</x-nav-link>
                <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">Menu</x-nav-link>
                @auth
                    @if(auth()->user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">Dashboard Admin</x-nav-link>
                    @else
                        <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">Keranjang ({{ auth()->user()->cart?->items->count() ?? 0 }})</x-nav-link>
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">Pesanan Saya</x-nav-link>
                    @endif
                @endauth
            </div>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            @guest
                <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Login</a>
                <a href="{{ route('register') }}" class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Register</a>
            @else
                <div class="flex items-center gap-3">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white">Dashboard Admin</a>
                    @else
                        <a href="{{ route('cart.index') }}" class="rounded-full bg-amber-400 px-4 py-2 text-sm font-medium text-slate-900">Keranjang ({{ auth()->user()->cart?->items->count() ?? 0 }})</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Logout</button>
                    </form>
                </div>
            @endguest
        </div>

        <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl p-2 text-slate-500 hover:bg-slate-100 md:hidden">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-emerald-100 bg-white md:hidden">
        <div class="mx-auto max-w-7xl space-y-1 px-4 py-3 sm:px-6 lg:px-8">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Beranda</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">Menu</x-responsive-nav-link>
            @auth
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">Dashboard Admin</x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">Keranjang</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">Pesanan Saya</x-responsive-nav-link>
                @endif
            @endauth
        </div>
    </div>
</nav>
