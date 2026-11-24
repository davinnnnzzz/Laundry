<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('category')->get();
        return view('customer.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'   => 'required|string|max:100',
            'whatsapp_number' => ['required', 'regex:/^08[0-9]{8,12}$/'],
            'service_id'      => 'required|array',
            'service_id.*'    => 'exists:services,id',
            'quantity'        => 'required|array',
            'quantity.*'      => 'integer|min:0|max:500',
        ]);

        // Ambil hanya layanan yang jumlahnya lebih dari 0
        $items = [];
        foreach ($request->service_id as $index => $serviceId) {
            $qty = (int) ($request->quantity[$index] ?? 0);
            if ($qty > 0) {
                $items[] = ['service_id' => $serviceId, 'quantity' => $qty];
            }
        }

        if (empty($items)) {
            return back()->withInput()->with('error', 'Pilih minimal satu layanan dengan jumlah lebih dari 0.');
        }

        // Transaction: order + semua detail tersimpan bersamaan, atau batal semua
        $order = DB::transaction(function () use ($request, $items) {
            $order = Order::create([
                'user_id'         => Auth::id(),
                'customer_name'   => $request->customer_name,
                'whatsapp_number' => $request->whatsapp_number,
                'total_price'     => 0,
                'status'          => 'Proses',
                'status_bayar'    => 'Belum Lunas',
            ]);

            $totalPrice = 0;

            foreach ($items as $item) {
                // Harga selalu diambil dari database, bukan dari input pelanggan
                $service  = Service::findOrFail($item['service_id']);
                $subtotal = $service->price_per_unit * $item['quantity'];
                $totalPrice += $subtotal;

                $order->orderDetails()->create([
                    'service_id'    => $service->id,
                    'qty_or_weight' => $item['quantity'],
                    'subtotal'      => $subtotal,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);

            return $order;
        });

        // Simpan nomor whatsapp ke profile jika user login belum punya nomor
        if (Auth::check() && empty(Auth::user()->whatsapp_number)) {
            Auth::user()->update(['whatsapp_number' => $request->whatsapp_number]);
        }

        return redirect()->route('home')->with(
            'success',
            'Pesanan LDR-'.$order->id.' berhasil dikirim. Total: Rp '.number_format($order->total_price, 0, ',', '.')
        );
    }

    public function customerOrders()
    {
        $orders = Order::with('orderDetails.service')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.orders', compact('orders'));
    }
}
