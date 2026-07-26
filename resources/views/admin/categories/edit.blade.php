@extends('layouts.admin')
@section('title', 'Edit Kategori')
@section('content')
<div class="max-w-2xl"><h2 class="text-2xl font-bold">Edit kategori</h2><form class="mt-6 space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm" method="POST" action="{{ route('admin.categories.update', $category) }}">@csrf @method('PUT') @include('admin.categories._form')<button class="rounded-2xl bg-emerald-600 px-5 py-3 font-semibold text-white">Perbarui</button></form></div>
@endsection
