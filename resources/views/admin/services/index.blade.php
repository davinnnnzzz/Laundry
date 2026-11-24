@extends('layouts.app')

@section('title', 'Kelola Layanan')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
    <div>
        <h2 class="fw-bold mb-1">Data Layanan dan Tarif Cuci</h2>
        <p class="text-secondary small mb-0">
            @if(Auth::user()->isAdmin())
                Kelola, tambah, ubah tarif, dan hapus jenis layanan laundry.
            @else
                Daftar jenis layanan dan tarif cuci aktif (Panduan Kasir).
            @endif
        </p>
    </div>
    @if(Auth::user()->isAdmin())
        <a href="{{ route('admin.services.create') }}" class="btn btn-success btn-sm align-self-start align-self-sm-center">
            <i class="bi bi-plus-circle me-1"></i> + Tambah Layanan
        </a>
    @else
        <span class="badge bg-secondary-subtle text-secondary-emphasis border px-3 py-2 align-self-start align-self-sm-center">
            <i class="bi bi-shield-lock me-1"></i> Mode Kasir: Hanya Lihat Tarif
        </span>
    @endif
</div>

<div class="card bg-white p-3">
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nama Layanan</th>
                    <th>Kategori</th>
                    <th>Tarif Satuan</th>
                    <th style="width: 170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td class="fw-semibold text-dark">{{ $service->service_name }}</td>
                        <td>
                            <span class="badge badge-kategori {{ in_array($service->category, ['Express', 'Ekspres', 'Ekspress']) ? 'bg-primary-subtle text-primary border border-primary-subtle' : ($service->category === 'Superkilat' ? 'bg-danger-subtle text-danger border border-danger-subtle' : ($service->category === 'Reguler' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle')) }}">
                                {{ $service->category }}
                            </span>
                        </td>
                        <td class="fw-bold text-success">Rp {{ number_format($service->price_per_unit, 0, ',', '.') }} / {{ $service->unit_type }}</td>
                        <td>
                            @if(Auth::user()->isAdmin())
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus layanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            @else
                                <span class="badge bg-light text-muted border">
                                    <i class="bi bi-lock me-1"></i> Khusus Admin
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
