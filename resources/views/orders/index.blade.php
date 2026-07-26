<x-app-layout>
    <x-slot name="header">
        <div class="space-y-2">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-emerald-600">Pesanan Saya</p>
            <h2 class="text-3xl font-bold text-slate-900">Riwayat pesanan</h2>
        </div>
    </x-slot>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            @if($orders->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Order</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="px-6 py-4 font-semibold text-slate-900">{{ $order->order_number }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-900">{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status_color }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('orders.show', $order->order_number) }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="px-8 py-16 text-center">
                    <h3 class="text-2xl font-bold text-slate-900">Belum ada pesanan</h3>
                    <p class="mt-3 text-slate-600">Mulai pesan menu favoritmu sekarang.</p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-2xl bg-emerald-600 px-5 py-3 font-semibold text-white">Lihat Menu</a>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
