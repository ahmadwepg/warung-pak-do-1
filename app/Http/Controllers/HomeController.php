<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $allCategories = Cache::remember('categories_ordered', 86400, function () {
            return Category::orderBy('sort_order')->get();
        });
        $categories = $allCategories->take(6);

        $featuredProducts = Cache::remember('featured_products', 3600, function () {
            return Product::with('category')
                ->where('is_active', true)
                ->latest()
                ->take(8)
                ->get();
        });

        return view('home', compact('categories', 'featuredProducts'));
    }
}
