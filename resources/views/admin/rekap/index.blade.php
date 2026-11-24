@extends('layouts.app')

@section('title', 'Rekap Laporan Laundry')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Rekapitulasi Laporan Transaksi</h2>
        <p class="text-secondary small mb-0">Rangkuman data penjualan, volume layanan, dan omset pendapatan laundry.</p>
    </div>
    <div class="d-flex flex-wrap gap-2 no-print">
        <button onclick="window.print()" class="btn btn-dark btn-sm">
            <i class="bi bi-printer me-1"></i> Cetak / Print Rekap
        </button>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<!-- Form Filter (Disembunyikan saat cetak) -->
<div class="card bg-white p-3 mb-4 no-print">
    <form action="{{ route('admin.rekap') }}" method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label small fw-semibold text-secondary">Dari Tanggal</label>
            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold text-secondary">Sampai Tanggal</label>
            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold text-secondary">Filter Status</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">-- Semua Status --</option>
                <option value="Proses" @selected($status === 'Proses')>Proses</option>
                <option value="Selesai" @selected($status === 'Selesai')>Selesai</option>
                <option value="Masuk" @selected($status === 'Masuk')>Masuk</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm flex-grow-1">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
            <a href="{{ route('admin.rekap') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
        </div>
    </form>
</div>

<!-- Kartu Ringkasan -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card bg-white p-3 border-start border-4 border-success h-100">
            <span class="text-secondary small fw-medium">Total Pendapatan (Selesai)</span>
            <h4 class="fw-bold text-success mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h4>
            <span class="text-muted small">Kas riil pesanan selesai</span>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card bg-white p-3 border-start border-4 border-primary h-100">
            <span class="text-secondary small fw-medium">Total Seluruh Transaksi</span>
            <h4 class="fw-bold text-primary mb-0">{{ $totalOrders }} Pesanan</h4>
            <span class="text-muted small">Nilai: Rp {{ number_format($potentialIncome, 0, ',', '.') }}</span>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card bg-white p-3 border-start border-4 border-warning h-100">
            <span class="text-secondary small fw-medium">Pesanan Dalam Proses</span>
            <h4 class="fw-bold text-warning mb-0">{{ $totalAntrean + $totalDicuci }}</h4>
            <span class="text-muted small">Proses: {{ $totalProses }} | Masuk: {{ $totalMasuk }}</span>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="card bg-white p-3 border-start border-4 border-info h-100">
            <span class="text-secondary small fw-medium">Tingkat Penyelesaian</span>
            <h4 class="fw-bold text-info mb-0">{{ $totalOrders > 0 ? round(($totalSelesai / $totalOrders) * 100) : 0 }}%</h4>
            <span class="text-muted small">{{ $totalSelesai }} dari {{ $totalOrders }} pesanan</span>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Rekap per Jenis Layanan -->
    <div class="col-12 col-lg-5">
        <div class="card bg-white p-3 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-pie-chart me-1"></i> Rangkuman Penjualan Layanan</h6>
            <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Layanan</th>
                            <th class="text-center">Total Volume</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($servicesBreakdown as $name => $data)
                            <tr>
                                <td class="fw-medium">{{ $name }}</td>
                                <td class="text-center">{{ $data['qty'] }} {{ $data['unit_type'] }}</td>
                                <td class="text-end fw-semibold">Rp {{ number_format($data['subtotal'], 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Tidak ada data layanan pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabel Rincian Data Transaksi -->
    <div class="col-12 col-lg-7">
        <div class="card bg-white p-3 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-list-check me-1"></i> Rincian Pesanan Terdata</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="fw-bold text-primary">LDR-{{ $order->id }}</td>
                                <td class="small">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="fw-semibold">{{ $order->customer_name }}</span>
                                    <span class="text-muted small d-block">{{ $order->whatsapp_number }}</span>
                                </td>
                                <td>
                                    @if($order->status === 'Selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($order->status === 'Proses' || $order->status === 'Dicuci')
                                        <span class="badge bg-primary">Proses</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Masuk</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                    <span class="badge {{ ($order->status_bayar ?? 'Belum Lunas') === 'Lunas' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning-emphasis border border-warning-subtle' }}" style="font-size: 0.68rem;">
                                        {{ $order->status_bayar ?? 'Belum Lunas' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">Belum ada transaksi sesuai filter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
