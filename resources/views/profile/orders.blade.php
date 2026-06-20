@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kartu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    <style>
        .order-card { background: white; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f0f0f0; overflow: hidden; transition: transform 0.2s; }
        .order-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .hotel-img { width: 180px; height: 100%; min-height: 180px; object-fit: cover; }
        .status-paid { background: #d4f1d4; color: #2d5a2d; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
        .status-pending { background: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
        .date-box { padding: 10px; background: #f8f9fa; border-radius: 6px; text-align: center; border: 1px solid #e2e8f0; }
        .price-tag { font-size: 1.2rem; font-weight: 700; color: #df9e38; }
        .btn-maps { background: #ffffff; color: #4b5563; border: 1px solid #d1d5db; border-radius: 6px; text-decoration: none; padding: 6px 14px; font-size: 0.85rem; font-weight: 500; }
        .btn-pay { background: #df9e38; color: white; border: none; border-radius: 6px; text-decoration: none; padding: 6px 14px; font-size: 0.85rem; font-weight: 600; }
        .btn-maps:hover { background: #f3f4f6; color: #111827; }
        .btn-pay:hover { background: #c78a2d; color: white; }
        .empty-message { text-align: center; padding: 40px; color: #9ca3af; }
        .empty-message i { font-size: 3rem; margin-bottom: 15px; color: #e5e7eb; }
    </style>
@endpush

@section('content')

@php
    // Mencegah error 'Undefined variable' sebelum backend dari Tegar benar-benar siap
    $bookings = $bookings ?? collect();
@endphp

<div class="container-fluid px-4 px-lg-5 py-4" style="max-width: 1440px;">
    
    <div class="profile-page-title mb-4">
        <a href="{{ route('home') }}"><i class="fa-solid fa-angle-left"></i></a>
        <h2>Pesanan Saya</h2>
    </div>

    <div class="row g-4">
        <div class="col-md-4 col-lg-3">
            @include('layouts.sidebar_profile')
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="section-title mb-0" style="border: none;">Riwayat Pemesanan</h4>
                <a href="{{ route('bookings.index') }}" class="btn-save" style="text-decoration: none; padding: 8px 16px; font-size: 0.85rem; margin-top: 0;">
                    <i class="fas fa-plus"></i> Pesan Kamar
                </a>
            </div>

            @if($bookings->isEmpty())
                <div class="profile-card text-center py-5">
                    <div class="empty-message">
                        <i class="fas fa-calendar-alt"></i>
                        <h5 class="fw-bold mt-2 text-dark">Belum Ada Pesanan</h5>
                        <p class="small">Mulai perjalanan Anda dengan memesan kamar hari ini!</p>
                        <a href="{{ route('bookings.index') }}" class="btn-save mt-2 d-inline-block text-decoration-none">Cari Kamar</a>
                    </div>
                </div>
            @else
                @foreach($bookings as $booking)
                    <div class="order-card d-flex flex-column flex-md-row">
                        <img src="@if($booking->resource->image){{ $booking->resource->image }}@else https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60 @endif" class="hotel-img" alt="{{ $booking->resource->name ?? 'Hotel Image' }}">
                        
                        <div class="p-4 flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $booking->resource->name ?? 'Nama Hotel' }}</h5>
                                    <small class="text-muted d-block mb-2">ID Pesanan: #{{ $booking->id }}</small>
                                    @if($booking->status === \App\Enums\BookingStatus::Pending)
                                        <span class="status-pending"><i class="fas fa-clock"></i> PERLU DIBAYAR</span>
                                    @elseif($booking->status === \App\Enums\BookingStatus::Confirmed)
                                        <span class="status-paid"><i class="fas fa-check-circle"></i> DIKONFIRMASI</span>
                                    @else
                                        <span class="status-pending bg-light text-secondary"><i class="fas fa-times-circle"></i> {{ strtoupper($booking->status->value) }}</span>
                                    @endif
                                </div>
                                <div class="d-flex gap-2 text-center">
                                    <div class="date-box">
                                        <small class="text-muted d-block" style="font-size: 0.65rem; font-weight: 600;">CHECK-IN</small>
                                        <span class="fw-bold text-dark d-block">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M') }}</span>
                                    </div>
                                    <div class="date-box">
                                        <small class="text-muted d-block" style="font-size: 0.65rem; font-weight: 600;">CHECK-OUT</small>
                                        <span class="fw-bold text-dark d-block">{{ \Carbon\Carbon::parse($booking->end_time)->format('d M') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-muted small mb-3">
                                <div class="col-6"><i class="fas fa-door-open me-1"></i> {{ $booking->resource->type ?? '-' }}</div>
                                <div class="col-6"><i class="fas fa-user me-1"></i> Tamu: {{ $booking->user->name ?? '-' }}</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top: 1px dashed #e5e7eb;">
                                <div class="price-tag">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn-maps">Detail</a>
                                    @if($booking->status === \App\Enums\BookingStatus::Pending)
                                        <a href="{{ route('bookings.payment', $booking->id) }}" class="btn-pay">Bayar Sekarang</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection