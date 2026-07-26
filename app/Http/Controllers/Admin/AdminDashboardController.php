<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalOrders = Order::count();
        $totalRevenue = (int) Order::sum('total_price');
        $lowStockProducts = Product::where('stock', '<=', 10)->count();
        $totalCustomers = User::where('role', 'customer')->count();

        $ordersByStatus = Order::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $recentCustomers = User::where('role', 'customer')
            ->latest()
            ->limit(5)
            ->get();

        $lowStockItems = Product::with('category')
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'lowStockProducts',
            'totalCustomers',
            'ordersByStatus',
            'recentOrders',
            'recentCustomers',
            'lowStockItems',
        ));
    }
}
