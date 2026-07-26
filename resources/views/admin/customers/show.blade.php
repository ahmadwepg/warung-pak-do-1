@extends('layouts.admin')
@section('title', 'Detail Pelanggan')
@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
        <p class="text-sm text-slate-500">{{ $user->email }} &middot; {{ $user->phone ?? '-' }}</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Pesanan</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $user->orders->count() }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Belanja</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700">Rp {{ number_format($user->orders->sum('total_price'), 0, ',', '.') }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Bergabung</p>
            <p class="mt-2 text-xl font-bold text-slate-900">{{ $user->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 p-6"><h3 class="text-lg font-bold">Riwayat Pesanan</h3></div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
                    <tr><th class="px-6 py-4">Order</th><th class="px-6 py-4">Tanggal</th><th class="px-6 py-4">Total</th><th class="px-6 py-4">Status</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($user->orders as $order)
                        <tr>
                            <td class="px-6 py-4 font-semibold">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status_color }}">{{ $order->status_label }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-10 text-center text-slate-500">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection