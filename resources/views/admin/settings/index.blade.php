@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('content')
<div class="max-w-2xl">
    <h2 class="text-2xl font-bold">Pengaturan Warung</h2>
    <form class="mt-6 space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm" method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Nama Warung</label>
            <input type="text" name="store_name" value="{{ old('store_name', $settings['store_name'] ?? '') }}" class="w-full rounded-2xl border-slate-200 px-4 py-3">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Rekening Bank</label>
            <input type="text" name="bank_account" value="{{ old('bank_account', $settings['bank_account'] ?? '') }}" placeholder="BCA 1234567890 a.n. Warung Pak Do" class="w-full rounded-2xl border-slate-200 px-4 py-3">
        </div>
        <button type="submit" class="rounded-2xl bg-emerald-600 px-5 py-3 font-semibold text-white">Simpan</button>
    </form>

    @if(session('success'))
        <div class="mt-4 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif
</div>
@endsection