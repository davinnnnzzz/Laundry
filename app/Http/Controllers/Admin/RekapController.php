<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate   = $request->query('end_date');
        $status    = $request->query('status');

        $query = Order::with('orderDetails.service')->latest();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($status && in_array($status, ['Masuk', 'Proses', 'Selesai', 'Antrean', 'Dicuci'])) {
            if ($status === 'Masuk' || $status === 'Antrean') {
                $query->whereIn('status', ['Masuk', 'Antrean']);
            } elseif ($status === 'Proses' || $status === 'Dicuci') {
                $query->whereIn('status', ['Proses', 'Dicuci']);
            } else {
                $query->where('status', 'Selesai');
            }
        }

        $orders = $query->get();

        // Rekapitulasi angka
        $totalOrders     = $orders->count();
        $totalIncome     = $orders->where('status', 'Selesai')->sum('total_price');
        $potentialIncome = $orders->sum('total_price');
        $totalMasuk      = $orders->whereIn('status', ['Masuk', 'Antrean'])->count();
        $totalProses     = $orders->whereIn('status', ['Proses', 'Dicuci'])->count();
        $totalSelesai    = $orders->where('status', 'Selesai')->count();
        $totalAntrean    = $totalMasuk;
        $totalDicuci     = $totalProses;

        // Rangkuman per layanan
        $servicesBreakdown = [];
        foreach ($orders as $order) {
            foreach ($order->orderDetails as $detail) {
                $serviceName = $detail->service->service_name ?? 'Layanan Lain';
                if (! isset($servicesBreakdown[$serviceName])) {
                    $servicesBreakdown[$serviceName] = [
                        'qty'       => 0,
                        'unit_type' => $detail->service->unit_type ?? 'Unit',
                        'subtotal'  => 0,
                    ];
                }
                $servicesBreakdown[$serviceName]['qty'] += $detail->qty_or_weight;
                $servicesBreakdown[$serviceName]['subtotal'] += $detail->subtotal;
            }
        }

        return view('admin.rekap.index', compact(
            'orders',
            'startDate',
            'endDate',
            'status',
            'totalOrders',
            'totalIncome',
            'potentialIncome',
            'totalMasuk',
            'totalProses',
            'totalAntrean',
            'totalDicuci',
            'totalSelesai',
            'servicesBreakdown'
        ));
    }
}
