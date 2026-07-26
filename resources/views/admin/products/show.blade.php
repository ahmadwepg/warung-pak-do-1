@extends('layouts.admin')
@section('title', 'Detail Produk')
@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold">{{ $product->name }}</h2>
            <p class="text-sm text-slate-500">{{ $product->category?->name }} &middot; {{ $product->formatted_price }}</p>
        </div>
        <a href="{{ route('admin.products.edit', $product) }}" class="rounded-2xl bg-emerald-600 px-5 py-3 font-semibold text-white">Edit Produk</a>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://placehold.co/600x400/png?text=' . urlencode($product->name) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
            <div><p class="text-sm text-slate-500">Stok</p><p class="text-2xl font-bold {{ $product->stock <= 10 ? 'text-rose-600' : 'text-slate-900' }}">{{ $product->stock }}</p></div>
            <div><p class="text-sm text-slate-500">Status</p><p class="text-lg font-semibold">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</p></div>
            <div><p class="text-sm text-slate-500">Deskripsi</p><p class="text-sm text-slate-600">{{ $product->description ?: '-' }}</p></div>
        </div>
    </div>

    @if($product->variants->isNotEmpty())
    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-bold">Varian</h3>
        <div class="mt-4 space-y-3">
            @foreach($product->variants as $variant)
                <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                    <div><p class="font-semibold">{{ $variant->variant_name }}</p><p class="text-sm text-slate-500">{{ implode(', ', $variant->options) }}</p></div>
                    <form method="POST" action="{{ route('admin.products.variants.destroy', [$product, $variant]) }}" onsubmit="return confirm('Hapus varian?')">@csrf @method('DELETE')<button class="text-sm font-semibold text-rose-600">Hapus</button></form>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection