@extends('layouts.admin')
@section('title', 'Laporan Penjualan')
@section('content')
<div class="flex items-center justify-between"><div><h2 class="text-2xl font-bold">Laporan Penjualan</h2><p class="text-sm text-slate-500">Filter periode dan export data.</p></div></div>
<div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Dari</label>
            <input type="date" name="from" value="{{ $from ?? '' }}" class="rounded-2xl border-slate-200 px-4 py-3">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Sampai</label>
            <input type="date" name="to" value="{{ $to ?? '' }}" class="rounded-2xl border-slate-200 px-4 py-3">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-2xl bg-emerald-600 px-5 py-3 font-semibold text-white">Filter</button>
            <a href="{{ route('admin.reports.export', ['from' => $from, 'to' => $to]) }}" class="rounded-2xl border border-slate-200 px-5 py-3 font-semibold text-slate-600 hover:bg-slate-50">Export CSV</a>
        </div>
    </form>
</div>

<div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-500">Total Pesanan</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalOrders }}</p>
    </div>
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-500">Total Pendapatan</p>
        <p class="mt-2 text-3xl font-bold text-emerald-700">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-500">Rata-rata / Pesanan</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalOrders ? 'Rp ' . number_format($totalRevenue / $totalOrders, 0, ',', '.') : 'Rp 0' }}</p>
    </div>
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-sm text-slate-500">Produk Terjual</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalItemsSold }}</p>
    </div>
</div>

<div class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 font-semibold">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 font-semibold">{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status_color }}">{{ $order->status_label }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="border-t border-slate-100 p-4">{{ $orders->links() }}</div>
</div>
@endsection