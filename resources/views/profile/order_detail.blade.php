@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .glass-card, .glass-card * {
                visibility: visible;
            }
            .glass-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
            }
            .btn, .page-header-profil, .back-arrow, nav, footer, .avatar-section, .sidebar-menu {
                display: none !important;
            }
        }
    </style>
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
                            @if($booking->status === \App\Enums\BookingStatus::Pending) <span class="badge bg-warning text-dark">PENDING</span>
                            @elseif($booking->status === \App\Enums\BookingStatus::Confirmed) <span class="badge bg-success">CONFIRMED</span>
                            @else <span class="badge bg-secondary">{{ strtoupper($booking->status->value) }}</span> @endif
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

            @if($booking->status === \App\Enums\BookingStatus::Pending)
                <div class="d-flex gap-2">
                    <a href="{{ route('bookings.payment', $booking->id) }}" class="btn btn-save text-decoration-none">
                        <i class="fas fa-credit-card me-1"></i> Lanjutkan Pembayaran
                    </a>
                </div>
            @elseif($booking->status === \App\Enums\BookingStatus::Confirmed && empty($booking->refund_status))
                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#refundModal">
                        <i class="fas fa-times-circle me-1"></i> Batalkan Pesanan & Ajukan Refund
                    </button>
                    <a href="{{ route('bookings.receipt', $booking->id) }}" target="_blank" class="btn btn-primary d-print-none">
                        <i class="fas fa-print me-1"></i> Cetak Struk Digital
                    </a>
                </div>
                
                <!-- Refund Modal -->
                <div class="modal fade" id="refundModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold" style="color: #1e293b;">Ajukan Refund</h5>
                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pt-3 pb-4">
                                <p class="text-muted mb-4" style="font-size: 0.95rem;">Pesanan Anda akan dibatalkan, dan permintaan pengembalian dana (refund) akan diproses oleh tim kami. Harap berikan alasan pembatalan di bawah ini.</p>
                                
                                <form action="{{ route('bookings.refund', $booking->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="refund_reason" class="form-label fw-bold" style="color: #334155;">Alasan Pembatalan <span class="text-danger">*</span></label>
                                        <textarea class="form-control shadow-none" id="refund_reason" name="refund_reason" rows="2" required placeholder="Contoh: Mengubah jadwal perjalanan, sakit, dll..." style="border-radius: 8px; border: 1px solid #cbd5e1;"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="refund_payment_method" class="form-label fw-bold" style="color: #334155;">Metode Refund <span class="text-danger">*</span></label>
                                        <select class="form-select shadow-none" id="refund_payment_method" name="refund_payment_method" required style="border-radius: 8px; border: 1px solid #cbd5e1;">
                                            <option value="" disabled selected hidden>Pilih Metode Pengembalian Dana</option>
                                            <option value="E-Wallet">E-Wallet (OVO/GoPay/Dana)</option>
                                            <option value="Bank Transfer">Transfer Bank</option>
                                            <option value="Kartu Kredit">Kartu Kredit</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="refund_payment_account" class="form-label fw-bold" style="color: #334155;">Nomor Rekening / No. HP E-Wallet <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none" id="refund_payment_account" name="refund_payment_account" required placeholder="Contoh: BCA 1234567890 / 08123456789" style="border-radius: 8px; border: 1px solid #cbd5e1;">
                                    </div>
                                    <div class="mb-4">
                                        <label for="refund_account_name" class="form-label fw-bold" style="color: #334155;">Atas Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control shadow-none" id="refund_account_name" name="refund_account_name" required placeholder="Nama pemilik rekening/akun" style="border-radius: 8px; border: 1px solid #cbd5e1;">
                                    </div>
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="font-weight: 500; border-radius: 6px;">Tutup</button>
                                        <button type="submit" class="btn btn-danger" style="font-weight: 500; border-radius: 6px;">Ajukan Refund</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($booking->refund_status === 'requested')
                <div class="alert alert-warning mt-3" role="alert" style="border-radius: 8px;">
                    <i class="fas fa-clock me-2"></i> Pengajuan refund Anda sedang diproses oleh tim Finance.
                </div>
            @elseif($booking->refund_status === 'completed')
                <div class="alert alert-success mt-3" role="alert" style="border-radius: 8px;">
                    <i class="fas fa-check-circle me-2"></i> Pengembalian dana (refund) telah dikonfirmasi dan selesai.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection