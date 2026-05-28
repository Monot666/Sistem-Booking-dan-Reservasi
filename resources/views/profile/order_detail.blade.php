@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')
<div class="container mt-5 mb-5" style="max-width: 1000px;">
    <div class="page-header-profil">
        <a href="{{ route('profile.orders') }}" class="back-arrow"><i class="fa-solid fa-angle-left"></i></a>
        <h2>Detail Pesanan #{{ $booking->id }}</h2>
    </div>

    <div class="row">
        <div class="col-md-4 col-lg-3 mb-4">
            @include('layouts.sidebar_profile')
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="glass-card mb-4">
                <h4 class="section-title">Informasi Booking</h4>
                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label-custom">Akomodasi</label>
                        <p class="fw-bold text-dark mb-0">{{ $booking->resource->name }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label-custom">Status</label>
                        <p class="mb-0">
                            @if($booking->status === 'pending') <span class="badge bg-warning text-dark">PENDING</span>
                            @elseif($booking->status === 'confirmed') <span class="badge bg-success">CONFIRMED</span>
                            @else <span class="badge bg-secondary">{{ strtoupper($booking->status) }}</span> @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label-custom">Check-In</label>
                        <p class="fw-bold text-dark mb-0">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label-custom">Check-Out</label>
                        <p class="fw-bold text-dark mb-0">{{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label-custom">Tamu Utama</label>
                        <p class="fw-bold text-dark mb-0">{{ $booking->user->name }}</p>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label-custom">Total Tagihan</label>
                        <p class="fw-bold mb-0" style="color: var(--brand-orange); font-size: 1.1rem;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            @if($booking->status === 'pending')
                <div class="d-flex gap-2">
                    <a href="{{ route('user.pembayaran', $booking->id) }}" class="btn btn-save text-decoration-none">
                        <i class="fas fa-credit-card me-1"></i> Lanjutkan Pembayaran
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection