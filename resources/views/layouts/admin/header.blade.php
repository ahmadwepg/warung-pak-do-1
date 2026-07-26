<header class="flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">Admin Area</p>
        <h1 class="text-lg font-bold text-slate-900">@yield('title', 'Dashboard')</h1>
    </div>

    <div class="flex items-center gap-3">
        <div class="hidden text-right sm:block">
            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
            <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
        </div>
        <div class="grid h-10 w-10 place-items-center rounded-full bg-emerald-100 font-bold text-emerald-700">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    </div>
</header>
