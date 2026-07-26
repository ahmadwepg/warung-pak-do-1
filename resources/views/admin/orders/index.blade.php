@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')
@section('content')
<div class="flex items-center justify-between"><div><h2 class="text-2xl font-bold">Pesanan</h2><p class="text-sm text-slate-500">Pantau status, update pengiriman, batalkan pesanan.</p></div></div>
<div class="mt-6 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm"><div class="overflow-x-auto"><table class="min-w-full divide-y divide-slate-100"><thead class="bg-slate-50 text-left text-xs uppercase text-slate-500"><tr><th class="px-6 py-4">Kode</th><th class="px-6 py-4">Pelanggan</th><th class="px-6 py-4">Total</th><th class="px-6 py-4">Status</th><th class="px-6 py-4">Aksi</th></tr></thead><tbody class="divide-y divide-slate-100">@forelse($orders as $order)<tr><td class="px-6 py-4 font-semibold">{{ $order->order_number }}</td><td class="px-6 py-4">{{ $order->user?->name }}</td><td class="px-6 py-4 font-semibold">{{ number_format($order->total_price, 0, ',', '.') }}</td><td class="px-6 py-4"><select onchange="updateStatus(this, '{{ route('admin.orders.status', $order) }}')" class="rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold {{ $order->status_color }} bg-opacity-20 text-slate-900"><option {{ $order->status === 'pending' ? 'selected' : '' }} value="pending">Menunggu</option><option {{ $order->status === 'diterima' ? 'selected' : '' }} value="diterima">Diterima</option><option {{ $order->status === 'disiapkan' ? 'selected' : '' }} value="disiapkan">Disiapkan</option><option {{ $order->status === 'dikirim' ? 'selected' : '' }} value="dikirim">Dikirim</option><option {{ $order->status === 'selesai' ? 'selected' : '' }} value="selesai">Selesai</option><option {{ $order->status === 'dibatalkan' ? 'selected' : '' }} value="dibatalkan">Dibatalkan</option></select></td><td class="px-6 py-4"><a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-emerald-700">Detail</a></td></tr>@empty<tr><td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada pesanan.</td></tr>@endforelse</tbody></table></div></div>
<script>
function updateStatus(select, url) {
    const map = { pending: 'bg-yellow-100 text-yellow-900', diterima: 'bg-blue-100 text-blue-900', disiapkan: 'bg-indigo-100 text-indigo-900', dikirim: 'bg-purple-100 text-purple-900', selesai: 'bg-green-100 text-green-900', dibatalkan: 'bg-red-100 text-red-900' };
    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ status: select.value }),
    }).then(() => {
        select.className = 'rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold bg-opacity-20 text-slate-900 ' + (map[select.value] || 'bg-gray-100');
    }).catch(console.error);
}
</script>
@endsection
