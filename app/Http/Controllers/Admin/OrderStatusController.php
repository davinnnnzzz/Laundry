<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status'       => 'nullable|in:Masuk,Proses,Selesai,Antrean,Dicuci',
            'status_bayar' => 'nullable|in:Belum Lunas,Lunas',
        ]);

        $order->update(array_filter($validated, fn ($val) => ! is_null($val)));

        return back()->with('success', 'Status pesanan LDR-'.$order->id.' diperbarui.');
    }
}
