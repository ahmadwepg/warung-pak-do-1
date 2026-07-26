<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()
            ->with(['category', 'variants'])
            ->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->string('category')));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->string('search').'%');
        }

        $products = $query->latest()->paginate(12)->withQueryString();
        $categories = Cache::remember('categories_ordered', 86400, function () {
            return Category::orderBy('sort_order')->get();
        });

        return view('products.index', compact('products', 'categories'));
    }

    public function byCategory(Category $category): View
    {
        $products = Product::query()
            ->with(['category', 'variants'])
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        $categories = Cache::remember('categories_ordered', 86400, function () {
            return Category::orderBy('sort_order')->get();
        });

        return view('products.index', compact('products', 'categories', 'category'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product = Cache::remember("product_{$product->slug}", 3600, function () use ($product) {
            return Product::with('category', 'variants', 'reviews.user')
                ->where('slug', $product->slug)
                ->firstOrFail();
        });

        $related = Product::where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('category')
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
