@extends('layouts.app')

@section('title', 'Pesan Laundry Express')

@section('content')
<!-- Hero Banner -->
<div class="card border-0 text-white p-4 p-md-5 mb-4 shadow" style="background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 55%, #06b6d4 100%); border-radius: 20px;">
    <div class="row align-items-center g-3">
        <div class="col-lg-8 text-center text-lg-start">
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill mb-3 fw-semibold shadow-sm">
                <i class="bi bi-stars me-1"></i> Bersih, Wangi &amp; Cepat
            </span>
            <h1 class="fw-bold mb-2 text-white display-6">Laundry Express</h1>
            <p class="mb-3 opacity-75">Layanan cuci kiloan, satuan, ekspres, dan superkilat dengan proses higienis dan tarif transparan.</p>
            <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-2 small">
                <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="bi bi-droplet-fill me-1"></i> Deterjen Premium</span>
                <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="bi bi-lightning-charge-fill me-1"></i> Tersedia Superkilat 5 Jam</span>
                <span class="badge bg-white bg-opacity-25 text-white px-3 py-2 rounded-pill"><i class="bi bi-shield-check me-1"></i> Rapi &amp; Tepat Waktu</span>
            </div>
        </div>
        <div class="col-lg-4 d-none d-lg-flex justify-content-end">
            <div class="bg-white bg-opacity-15 p-4 rounded-4 text-center border border-white border-opacity-25">
                <svg width="84" height="84" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <rect x="8" y="6" width="48" height="52" rx="10" fill="#ffffff" stroke="#bae6fd" stroke-width="3"/>
                    <line x1="8" y1="19" x2="56" y2="19" stroke="#bae6fd" stroke-width="3"/>
                    <circle cx="19" cy="12.5" r="2.5" fill="#0284c7"/>
                    <circle cx="28" cy="12.5" r="2.5" fill="#0ea5e9"/>
                    <circle cx="44" cy="12.5" r="2.5" fill="#06b6d4"/>
                    <circle cx="32" cy="38" r="13" fill="#e0f2fe" stroke="#0284c7" stroke-width="3"/>
                    <circle class="logo-drum-ring" cx="32" cy="38" r="9.5" stroke="#0284c7" stroke-opacity="0.35" stroke-width="2" stroke-dasharray="6 4"/>
                    <path class="logo-wave" d="M21 38c3-4 7-4 11 0s8 4 11 0" stroke="#0284c7" stroke-width="3" stroke-linecap="round"/>
                    <circle class="logo-bubble" cx="27" cy="32.5" r="2.2" fill="#0ea5e9"/>
                </svg>
                <div class="small fw-semibold mt-2 text-white">Siap Melayani Anda</div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('orders.store') }}" method="POST" id="orderForm">
    @csrf

    <!-- 1. Informasi Pelanggan -->
    <div class="card bg-white p-3 p-md-4 mb-4 border-start border-4 border-info">
        <h5 class="fw-bold text-dark mb-3">
            <i class="bi bi-person-badge-fill text-info me-2"></i>1. Informasi Pelanggan
        </h5>
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-person text-primary"></i></span>
                    <input type="text" name="customer_name" class="form-control" 
                           placeholder="Masukkan nama pelanggan" 
                           value="{{ old('customer_name', Auth::user()?->name ?? '') }}" required>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label small fw-semibold text-secondary">Nomor WhatsApp</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-whatsapp text-success"></i></span>
                    <input type="text" name="whatsapp_number" class="form-control" 
                           placeholder="Contoh: 081234567890" 
                           value="{{ old('whatsapp_number', Auth::user()?->whatsapp_number ?? '') }}" required>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Pilih Layanan -->
    <div class="mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-basket2-fill text-primary me-2"></i>2. Pilih Layanan
            </h5>
            <div class="d-flex flex-wrap gap-1" id="categoryFilters">
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 filter-cat-btn active" data-cat="all">Semua</button>
                @foreach ($services->pluck('category')->unique() as $cat)
                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 filter-cat-btn" data-cat="{{ $cat }}">{{ $cat }}</button>
                @endforeach
            </div>
        </div>

        <div class="row g-3">
            @forelse ($services as $service)
                <div class="col-12 col-md-6 col-lg-4 service-item" data-category="{{ $service->category }}">
                    <div class="card h-100 bg-white p-3 d-flex flex-column justify-content-between border-top border-4 {{ in_array($service->category, ['Express', 'Ekspres', 'Ekspress']) ? 'border-primary' : ($service->category === 'Superkilat' ? 'border-danger' : ($service->category === 'Reguler' ? 'border-success' : ($service->category === 'Satuan' ? 'border-info' : 'border-secondary'))) }}">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2 gap-2">
                                <span class="badge badge-kategori {{ in_array($service->category, ['Express', 'Ekspres', 'Ekspress']) ? 'bg-primary-subtle text-primary border border-primary-subtle' : ($service->category === 'Superkilat' ? 'bg-danger-subtle text-danger border border-danger-subtle' : ($service->category === 'Reguler' ? 'bg-success-subtle text-success border border-success-subtle' : ($service->category === 'Satuan' ? 'bg-info-subtle text-info-emphasis border border-info-subtle' : 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle'))) }}">
                                    {{ $service->category }}
                                </span>
                                <span class="fw-bold text-success fs-6 text-end">
                                    Rp {{ number_format($service->price_per_unit, 0, ',', '.') }} <span class="text-muted small fw-normal">/ {{ $service->unit_type }}</span>
                                </span>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $service->service_name }}</h6>
                            <p class="text-muted small mb-3" style="min-height: 38px;">{{ $service->description }}</p>
                        </div>
                        <div>
                            <input type="hidden" name="service_id[]" value="{{ $service->id }}">
                            <label class="form-label text-muted small fw-medium mb-1">Jumlah ({{ $service->unit_type }})</label>
                            <div class="input-group input-group-sm">
                                <button type="button" class="btn btn-outline-secondary qty-minus" aria-label="Kurangi">
                                    <i class="bi bi-dash-lg"></i>
                                </button>
                                <input type="number" name="quantity[]" class="form-control text-center fw-bold bg-light qty-input"
                                       data-price="{{ $service->price_per_unit }}" value="0" min="0" max="500">
                                <button type="button" class="btn btn-outline-primary qty-plus" aria-label="Tambah">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">Belum ada layanan tersedia saat ini.</div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Ringkasan & Tombol Submit -->
    <div class="card bg-white p-3 p-md-4 border-primary border-opacity-50 shadow-sm mt-4 mb-5">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-3">
            <div>
                <div class="text-secondary small fw-medium">Estimasi Total Biaya (<span id="selectedCount">0</span> item dipilih)</div>
                <div class="fs-4 fw-bold text-primary" id="liveTotal">Rp 0</div>
            </div>
            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill shadow">
                <i class="bi bi-bag-check-fill me-2"></i>Pesan Sekarang
            </button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const qtyInputs = document.querySelectorAll('.qty-input');
    const liveTotalEl = document.getElementById('liveTotal');
    const selectedCountEl = document.getElementById('selectedCount');

    function updateSummary() {
        let total = 0;
        let items = 0;
        qtyInputs.forEach(input => {
            const qty = Math.max(0, parseInt(input.value || 0, 10));
            const price = parseInt(input.dataset.price || 0, 10);
            if (qty > 0) {
                items += 1;
                total += qty * price;
            }
        });
        selectedCountEl.textContent = items;
        liveTotalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.querySelectorAll('.qty-plus').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('.qty-input');
            input.value = Math.min(500, (parseInt(input.value || 0, 10) + 1));
            updateSummary();
        });
    });

    document.querySelectorAll('.qty-minus').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('.qty-input');
            input.value = Math.max(0, (parseInt(input.value || 0, 10) - 1));
            updateSummary();
        });
    });

    qtyInputs.forEach(input => {
        input.addEventListener('input', updateSummary);
    });

    document.querySelectorAll('.filter-cat-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-cat-btn').forEach(b => {
                b.classList.remove('btn-primary', 'active');
                b.classList.add('btn-outline-primary');
            });
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-primary', 'active');

            const cat = btn.dataset.cat;
            document.querySelectorAll('.service-item').forEach(card => {
                card.style.display = (cat === 'all' || card.dataset.category === cat) ? '' : 'none';
            });
        });
    });
});
</script>
@endsection
