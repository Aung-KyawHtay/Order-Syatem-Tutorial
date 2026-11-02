<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        // Total Items
        $totalItems = Item::count();

        // Total Orders of Logged-in User
        $totalOrders = Order::where('user_id', $userId)->count();

        // Pending Orders
        $pendingOrders = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        // Completed Orders
        $completedOrders = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        // Latest 5 Orders
        $recentOrders = Order::with('user')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalItems',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'recentOrders'
        ));
    }
}
