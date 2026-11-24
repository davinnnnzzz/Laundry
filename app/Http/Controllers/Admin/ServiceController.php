<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('category')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name'   => 'required|string|max:100',
            'category'       => 'required|string|max:50',
            'price_per_unit' => 'required|integer|min:0',
            'unit_type'      => 'required|in:Kg,Pcs',
            'description'    => 'nullable|string',
        ]);

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'service_name'   => 'required|string|max:100',
            'category'       => 'required|string|max:50',
            'price_per_unit' => 'required|integer|min:0',
            'unit_type'      => 'required|in:Kg,Pcs',
            'description'    => 'nullable|string',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        // Layanan yang sudah dipakai transaksi tidak boleh dihapus
        if ($service->orderDetails()->exists()) {
            return back()->with('error', 'Layanan sudah dipakai di transaksi, tidak bisa dihapus.');
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
