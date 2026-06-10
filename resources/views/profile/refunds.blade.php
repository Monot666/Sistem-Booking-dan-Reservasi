@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    <style>
        .empty-message { text-align: center; padding: 60px 20px; color: #9ca3af; }
        .empty-message i { font-size: 4rem; margin-bottom: 20px; color: #e5e7eb; }
        .refund-info-text { font-size: 0.9rem; color: #6b7280; }
    </style>
@endpush

@section('content')
<!-- Layout Penuh 1440px -->
<div class="container-fluid px-4 px-lg-5 py-4" style="max-width: 1440px;">
    
    <!-- HEADER PROFIL (Seragam & Kembali ke Landing Page) -->
    <div class="profile-page-title mb-4">
        <a href="{{ route('home') }}"><i class="fa-solid fa-angle-left"></i></a>
        <h2>Riwayat Refunds</h2>
    </div>

    <div class="row g-4">
        <!-- ===================== SIDEBAR ===================== -->
        <div class="col-md-4 col-lg-3">
            @include('layouts.sidebar_profile')
        </div>

        <!-- ===================== MAIN CONTENT ===================== -->
        <div class="col-md-8 col-lg-9">
            
            <!-- Dibungkus profile-card agar selaras dengan halaman lain -->
            <div class="profile-card form-content-area">
                
                <div class="border-bottom pb-3 mb-4">
                    <h4 class="section-title mb-1" style="border: none; padding-bottom: 0;">Status Pengembalian Dana</h4>
                    <p class="refund-info-text mb-0">Lacak riwayat pengembalian dana dari pemesanan yang dibatalkan secara valid.</p>
                </div>

                <!-- Tampilan Ketika Kosong -->
                <div class="text-center py-5 my-3">
                    <div class="empty-message">
                        <i class="fas fa-hand-holding-dollar"></i>
                        <h5 class="fw-bold text-dark mt-3">Belum Ada Riwayat Refund</h5>
                        <p class="small px-md-5">Anda belum memiliki riwayat pengembalian dana saat ini. Dana akan otomatis diproses di sini apabila Anda membatalkan pesanan yang eligible.</p>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>
@endsection