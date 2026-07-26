@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Pesanan</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalOrders }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Pendapatan</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Stok Rendah</p>
            <p class="mt-2 text-3xl font-bold text-rose-600">{{ $lowStockProducts }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Pelanggan</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalCustomers }}</p>
        </div>
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-2">
        <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 p-6">
                <h3 class="text-lg font-bold text-slate-900">Pesanan Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                        <tr>
                            <th class="px-6 py-4">Order</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="px-6 py-4 font-semibold text-slate-900">{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $order->user?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($order->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900">Status Pesanan</h3>
                <div class="mt-4 space-y-3">
                    @foreach($ordersByStatus as $status => $count)
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-sm font-medium text-slate-700">{{ ucfirst($status) }}</span>
                            <span class="text-sm font-bold text-slate-900">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900">Produk Stok Rendah</h3>
                <div class="mt-4 space-y-3">
                    @forelse($lowStockItems as $product)
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                                <p class="text-xs text-slate-500">{{ $product->category?->name }}</p>
                            </div>
                            <span class="text-sm font-bold text-rose-600">{{ $product->stock }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Tidak ada produk stok rendah.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-slate-900">Pelanggan Terbaru</h3>
                <div class="mt-4 space-y-3">
                    @forelse($recentCustomers as $customer)
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $customer->name }}</p>
                                <p class="text-xs text-slate-500">{{ $customer->email }}</p>
                            </div>
                            <a href="#" class="text-sm font-semibold text-emerald-700">Detail</a>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada pelanggan.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
