@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        @if(Auth::user()->isAdmin())
            <h2 class="fw-bold mb-1">Dashboard Administrator</h2>
            <p class="text-secondary small mb-0">Kelola master layanan, pantau seluruh antrean, dan monitor laporan keuangan.</p>
        @else
            <h2 class="fw-bold mb-1">Dashboard Kasir</h2>
            <p class="text-secondary small mb-0">Pencatatan transaksi baru, pemantauan cucian, dan pembaruan status pengerjaan (Proses ➔ Selesai).</p>
        @endif
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Transaksi Baru
        </a>
        <a href="{{ route('admin.rekap') }}" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-bar-graph me-1"></i> Rekap Transaksi
        </a>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.services.index') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-gear me-1"></i> Kelola Layanan
            </a>
        @else
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-tag me-1"></i> Daftar Tarif Layanan
            </a>
        @endif
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card bg-white p-3 border-start border-4 border-warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-medium">Pesanan Status Antrean</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalAntrean }}</h3>
                </div>
                <div class="bg-warning-subtle text-warning p-3 rounded-circle">
                    <i class="bi bi-hourglass-split fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-white p-3 border-start border-4 border-primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-medium">Total Seluruh Pesanan</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $orders->count() }}</h3>
                </div>
                <div class="bg-primary-subtle text-primary p-3 rounded-circle">
                    <i class="bi bi-receipt fs-4"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-white p-3 border-start border-4 border-success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-medium">Pesanan Selesai</span>
                    <h3 class="fw-bold mb-0 text-dark">{{ $orders->where('status', 'Selesai')->count() }}</h3>
                </div>
                <div class="bg-success-subtle text-success p-3 rounded-circle">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card bg-white p-3">
    <h5 class="fw-bold mb-3">Daftar Transaksi Pesanan</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 80px;">Kode</th>
                    <th>Pelanggan</th>
                    <th>WhatsApp</th>
                    <th>Layanan Dipesan</th>
                    <th>Total Biaya</th>
                    <th style="width: 220px;">Ubah Status</th>
                    <th>Waktu Pesan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="fw-bold text-primary">LDR-{{ $order->id }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $order->customer_name }}</div>
                            @if($order->user_id)
                                <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle" style="font-size: 0.65rem;">Member</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle" style="font-size: 0.65rem;">Tamu</span>
                            @endif
                        </td>
                        <td>
                            <a href="https://wa.me/62{{ substr($order->whatsapp_number, 1) }}" target="_blank" rel="noopener" class="btn btn-outline-success btn-sm py-0 px-2 text-decoration-none">
                                <i class="bi bi-whatsapp me-1"></i>{{ $order->whatsapp_number }}
                            </a>
                        </td>
                        <td>
                            @foreach ($order->orderDetails as $detail)
                                <div class="small">
                                    • {{ $detail->service->service_name ?? 'Layanan' }} 
                                    <strong>x{{ $detail->qty_or_weight }} {{ $detail->service->unit_type ?? '' }}</strong>
                                </div>
                            @endforeach
                        </td>
                        <td>
                            <div class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                            <span class="badge {{ ($order->status_bayar ?? 'Belum Lunas') === 'Lunas' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' }}" style="font-size: 0.68rem;">
                                {{ $order->status_bayar ?? 'Belum Lunas' }}
                            </span>
                        </td>
                        <td>
                            <div class="mb-1">
                                @if($order->status === 'Selesai')
                                    <span class="badge bg-success px-2 py-1" style="font-size: 0.72rem;"><i class="bi bi-check2-circle me-1"></i>Selesai</span>
                                @elseif($order->status === 'Proses' || $order->status === 'Dicuci')
                                    <span class="badge bg-primary px-2 py-1" style="font-size: 0.72rem;"><i class="bi bi-arrow-repeat me-1"></i>Proses</span>
                                @else
                                    <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 0.72rem;"><i class="bi bi-hourglass-split me-1"></i>Masuk</span>
                                @endif
                            </div>
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-flex flex-column gap-1">
                                @csrf
                                @method('PATCH')
                                <div class="d-flex gap-1">
                                    <select name="status" class="form-select form-select-sm {{ $order->status === 'Selesai' ? 'border-success' : 'border-primary' }}">
                                        <option value="Proses" @selected($order->status === 'Proses' || $order->status === 'Dicuci')>Proses</option>
                                        <option value="Selesai" @selected($order->status === 'Selesai')>Selesai</option>
                                        <option value="Masuk" @selected($order->status === 'Masuk' || $order->status === 'Antrean')>Masuk</option>
                                    </select>
                                    <select name="status_bayar" class="form-select form-select-sm" style="font-size: 0.75rem;">
                                        <option value="Belum Lunas" @selected(($order->status_bayar ?? 'Belum Lunas') === 'Belum Lunas')>Belum Lunas</option>
                                        <option value="Lunas" @selected(($order->status_bayar ?? 'Belum Lunas') === 'Lunas')>Lunas</option>
                                    </select>
                                    <button class="btn btn-sm btn-primary">Simpan</button>
                                </div>
                            </form>
                        </td>
                        <td class="small text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada pesanan masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
