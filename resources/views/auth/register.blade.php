@extends('layouts.app')

@section('title', 'Daftar Akun Pelanggan - Laundry Express')

@section('content')
<div class="row justify-content-center mt-3 mt-md-4">
    <div class="col-12 col-sm-10 col-md-7 col-lg-5">
        <div class="card bg-white p-4 shadow-sm border-top border-4 border-info">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 rounded-4 p-3 mb-3">
                    <svg width="40" height="40" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <rect x="8" y="6" width="48" height="52" rx="10" fill="#e0f2fe" stroke="#0284c7" stroke-width="4"/>
                        <line x1="8" y1="19" x2="56" y2="19" stroke="#0284c7" stroke-width="3.5"/>
                        <circle cx="19" cy="12.5" r="2.5" fill="#0284c7"/>
                        <circle cx="28" cy="12.5" r="2.5" fill="#0ea5e9"/>
                        <circle cx="44" cy="12.5" r="2.5" fill="#06b6d4"/>
                        <circle cx="32" cy="38" r="13" fill="#ffffff" stroke="#0284c7" stroke-width="3.5"/>
                        <circle class="logo-drum-ring" cx="32" cy="38" r="9.5" stroke="#bae6fd" stroke-width="2" stroke-dasharray="6 4"/>
                        <path class="logo-wave" d="M21 38c3-4 7-4 11 0s8 4 11 0" stroke="#0ea5e9" stroke-width="3.5" stroke-linecap="round"/>
                        <circle class="logo-bubble" cx="27" cy="32.5" r="2.2" fill="#38bdf8"/>
                    </svg>
                </div>
                <h3 class="fw-bold text-dark">Daftar Akun Baru</h3>
                <p class="text-secondary small">Daftar untuk memantau status pesanan dan riwayat laundry Anda</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label for="name" class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso">
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label small fw-semibold text-secondary">Alamat Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="budi@gmail.com">
                </div>

                <!-- Nomor WhatsApp -->
                <div class="mb-3">
                    <label for="whatsapp_number" class="form-label small fw-semibold text-secondary">Nomor WhatsApp</label>
                    <input id="whatsapp_number" type="text" name="whatsapp_number" class="form-control" value="{{ old('whatsapp_number') }}" placeholder="081234567890">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label small fw-semibold text-secondary">Password</label>
                    <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="Ulangi password">
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary fw-semibold py-2">
                        Daftar Sebagai Pelanggan
                    </button>
                </div>

                <div class="text-center small text-secondary">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
