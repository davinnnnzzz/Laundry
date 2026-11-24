<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderDetails.service')->latest()->get();
        $totalAntrean = Order::whereIn('status', ['Antrean', 'Masuk', 'Proses', 'Dicuci'])->count();
        return view('admin.dashboard', compact('orders', 'totalAntrean'));
    }
}
