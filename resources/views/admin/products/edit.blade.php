@extends('layouts.admin')
@section('title', 'Edit Produk')
@section('content')
<div class="max-w-3xl"><h2 class="text-2xl font-bold">Edit produk</h2><form class="mt-6 space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm" method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.products._form')<button class="rounded-2xl bg-emerald-600 px-5 py-3 font-semibold text-white">Perbarui</button></form></div>
@endsection
