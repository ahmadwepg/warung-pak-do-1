@if(session('success') || session('error'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition.opacity.scale
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed right-4 top-4 z-50 w-full max-w-sm rounded-2xl border px-4 py-4 shadow-2xl"
         :class="{{ session('error') ? "'border-rose-200 bg-rose-50 text-rose-800'" : "'border-emerald-200 bg-emerald-50 text-emerald-800'" }}">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em]">{{ session('error') ? 'Gagal' : 'Berhasil' }}</p>
                <p class="mt-1 text-sm leading-6">{{ session('error') ?? session('success') }}</p>
            </div>
            <button type="button" class="text-lg leading-none opacity-60 hover:opacity-100" @click="show = false">×</button>
        </div>
    </div>
@endif
