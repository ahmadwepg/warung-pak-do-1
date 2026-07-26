<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $from = $request->date('from')?->startOfDay();
        $to = $request->date('to')?->endOfDay();

        $query = Order::query();

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        $orders = $query->with('user')->latest()->paginate(20)->withQueryString();
        $totalRevenue = (clone $query)->sum('total_price');
        $totalOrders = (clone $query)->count();

        $itemQuery = OrderItem::query();
        if ($from) {
            $itemQuery->whereHas('order', fn ($q) => $q->whereDate('created_at', '>=', $from));
        }
        if ($to) {
            $itemQuery->whereHas('order', fn ($q) => $q->whereDate('created_at', '<=', $to));
        }
        $totalItemsSold = (int) $itemQuery->sum('quantity');

        return view('admin.reports.index', compact('orders', 'totalRevenue', 'totalOrders', 'totalItemsSold', 'from', 'to'));
    }

    public function export(Request $request): Response
    {
        $from = $request->date('from')?->startOfDay();
        $to = $request->date('to')?->endOfDay();

        $query = Order::query()->with('user')->latest();

        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }

        $filename = 'sales-report-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Order Number', 'Tanggal', 'Pelanggan', 'Total', 'Status']);

            $query->chunk(100, function ($orders) use ($handle) {
                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->order_number,
                        $order->created_at->format('Y-m-d H:i:s'),
                        $order->user?->name,
                        $order->total_price,
                        $order->status,
                    ]);
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
