<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending_payment')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 5)
            ->where('is_active', true)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'totalCustomers',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}
