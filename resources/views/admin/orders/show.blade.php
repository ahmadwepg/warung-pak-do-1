@extends('layouts.admin')
@section('title', 'Detail Pesanan ' . $order->order_number)
@section('content')
@php
    $validStatuses = [
        'pending' => ['diterima', 'dibatalkan'],
        'diterima' => ['disiapkan', 'dibatalkan'],
        'disiapkan' => ['dikirim', 'dibatalkan'],
        'dikirim' => ['selesai', 'dibatalkan'],
    ];

    $statusLabels = [
        'pending' => 'Menunggu Konfirmasi',
        'diterima' => 'Pesanan Diterima',
        'disiapkan' => 'Sedang Disiapkan',
        'dikirim' => 'Sedang Diantar',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];

    $allowedNext = $validStatuses[$order->status] ?? [];
    $statusFlow = ['pending', 'diterima', 'disiapkan', 'dikirim', 'selesai'];
    $currentIndex = in_array($order->status, $statusFlow, true) ? array_search($order->status, $statusFlow, true) : -1;
@endphp

<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold">Order #{{ $order->order_number }}</h2>
            <p class="text-sm text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="rounded-full px-4 py-2 text-sm font-semibold {{ $order->status_color }}">
            {{ $order->status_label }}
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="font-bold text-slate-900">Pelanggan</h3>
            <p class="mt-2 text-sm text-slate-900">{{ $order->user->name }}</p>
            <p class="text-sm text-slate-600">{{ $order->phone }}</p>
            <p class="mt-2 text-sm text-slate-600">{{ $order->address ?: '-' }}</p>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="font-bold text-slate-900">Pembayaran</h3>
            <p class="mt-2 text-sm text-slate-600">Metode: {{ ucfirst($order->payment_method) }}</p>
            <p class="text-sm text-slate-600">Status: {{ ucfirst($order->payment_status) }}</p>
            <p class="mt-2 text-sm text-slate-600">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h3 class="text-lg font-semibold text-slate-900">Item Pesanan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-[0.2em] text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Varian</th>
                        <th class="px-6 py-4">Qty</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $item->product->name ?? 'Produk' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $item->variant_value ?: 'Standar' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-slate-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-900">Timeline Status</h3>
        <div class="mt-6 flex flex-col gap-3 md:flex-row md:items-center md:gap-2">
            @if($order->status === 'dibatalkan')
                <div class="flex items-center rounded-2xl bg-rose-50 px-4 py-3 text-rose-700">
                    <svg class="mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    <span class="font-semibold">Pesanan Dibatalkan</span>
                </div>
            @else
                @foreach($statusFlow as $index => $status)
                    <div class="flex flex-1 items-center gap-3">
                        <div class="grid h-8 w-8 place-items-center rounded-full {{ $index <= $currentIndex ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                            @if($index <= $currentIndex)
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @else
                                <span class="text-xs">{{ $index + 1 }}</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Step {{ $index + 1 }}</p>
                            <p class="text-sm font-semibold {{ $index <= $currentIndex ? 'text-emerald-700' : 'text-slate-600' }}">{{ $statusLabels[$status] }}</p>
                        </div>
                        @if($index < count($statusFlow) - 1)
                            <div class="hidden h-1 flex-1 rounded-full {{ $index < $currentIndex ? 'bg-emerald-500' : 'bg-slate-200' }} md:block"></div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-900">Update Status Pesanan</h3>

        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="mt-5 space-y-4" onsubmit="return confirm('Yakin ingin mengubah status pesanan ini?')">
            @csrf
            @method('PATCH')

            <div class="grid gap-4 sm:grid-cols-[1fr_auto] sm:items-end">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Status Baru</label>
                    <select name="status" class="w-full rounded-2xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500" {{ empty($allowedNext) ? 'disabled' : '' }}>
                        @if(empty($allowedNext))
                            <option value="">Status final (tidak dapat diubah)</option>
                        @else
                            <option value="">Pilih status</option>
                            @foreach($allowedNext as $status)
                                <option value="{{ $status }}">{{ $statusLabels[$status] }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('status') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    @if(! empty($allowedNext))
                        <button type="submit" class="rounded-2xl bg-emerald-600 px-6 py-3 font-semibold text-white hover:bg-emerald-700">Update Status</button>
                    @else
                        <span class="text-sm italic text-slate-500">Pesanan final</span>
                    @endif
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="mt-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mt-4 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-800">{{ session('error') }}</div>
        @endif
    </div>
</div>
@endsection
