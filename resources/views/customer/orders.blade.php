@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Riwayat Pesanan Saya</h3>
        <p class="text-secondary small mb-0">Pantau status pengerjaan pakaian laundry Anda di sini.</p>
    </div>
    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-plus-circle me-1"></i> Buat Pesanan Baru
    </a>
</div>

<div class="card bg-white p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Waktu Pesan</th>
                    <th>Detail Layanan</th>
                    <th>Total Bayar</th>
                    <th>Status Pengerjaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="fw-bold text-primary">LDR-{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @foreach ($order->orderDetails as $detail)
                                <span class="d-block small">
                                    • {{ $detail->service->service_name ?? 'Layanan' }} 
                                    <strong>x{{ $detail->qty_or_weight }} {{ $detail->service->unit_type ?? '' }}</strong> 
                                    <span class="text-muted">(Rp {{ number_format($detail->subtotal, 0, ',', '.') }})</span>
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <div class="fw-bold text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                            <span class="badge {{ ($order->status_bayar ?? 'Belum Lunas') === 'Lunas' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' }}" style="font-size: 0.68rem;">
                                {{ $order->status_bayar ?? 'Belum Lunas' }}
                            </span>
                        </td>
                        <td>
                            @if($order->status === 'Selesai')
                                <span class="badge bg-success px-2 py-1"><i class="bi bi-check2-circle me-1"></i>Selesai</span>
                            @elseif($order->status === 'Dicuci')
                                <span class="badge bg-primary px-2 py-1"><i class="bi bi-droplet-half me-1"></i>Sedang Dicuci</span>
                            @elseif($order->status === 'Proses')
                                <span class="badge bg-primary px-2 py-1"><i class="bi bi-arrow-repeat me-1"></i>Proses</span>
                            @else
                                <span class="badge bg-warning text-dark px-2 py-1"><i class="bi bi-hourglass-split me-1"></i>Masuk</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="bi bi-basket3 fs-2 d-block mb-2 text-secondary"></i>
                            Anda belum pernah membuat pesanan laundry.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
