@csrf
<div class="space-y-4">
    <!-- Nama Produk -->
    <div>
        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Produk</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}"
               class="w-full px-4 py-3 border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
               placeholder="Masukkan nama produk" required>
        @error('name')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Kategori -->
    <div>
        <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
        <select name="category_id" id="category_id"
                class="w-full px-4 py-3 border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Harga -->
    <div>
        <label for="price" class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
        <input type="number" name="price" id="price" value="{{ old('price', $product->price ?? '') }}"
               class="w-full px-4 py-3 border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
               placeholder="Contoh: 15000" min="0" required>
        @error('price')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Stok -->
    <div>
        <label for="stock" class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
        <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock ?? 0) }}"
               class="w-full px-4 py-3 border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
               placeholder="Jumlah stok" min="0" required>
        @error('stock')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Deskripsi -->
    <div>
        <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
        <textarea name="description" id="description" rows="3"
                  class="w-full px-4 py-3 border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                  placeholder="Deskripsi produk">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Gambar -->
    <div>
        <label for="image" class="block text-sm font-medium text-slate-700 mb-1">Gambar Produk</label>
        <input type="file" name="image" id="image" accept="image/*"
               class="w-full px-4 py-3 border border-slate-200 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
        @if(isset($product) && $product->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                     class="h-20 w-20 object-cover rounded-xl">
            </div>
        @endif
        @error('image')
            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status -->
    <div>
        <label class="flex items-center">
            <input type="checkbox" name="is_active" value="1"
                   {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
                   class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded">
            <span class="ml-2 text-sm text-slate-700">Produk Aktif</span>
        </label>
    </div>

    <!-- Buttons -->
    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
        <a href="{{ route('admin.products.index') }}"
           class="px-5 py-3 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50">
            Batal
        </a>
        <button type="submit"
                class="px-5 py-3 text-sm font-medium text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700">
            Simpan
        </button>
    </div>
</div>