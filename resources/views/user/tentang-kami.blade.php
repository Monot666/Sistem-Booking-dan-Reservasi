@extends('layouts.app')

@section('content')
<link href="{{ asset('assets/css/tentang-kami.css') }}" rel="stylesheet">

<div class="bg-white py-3 px-4 shadow-sm position-relative" style="z-index: 4;">
    <a href="{{ route('home') }}" class="text-decoration-none" style="color: #df9e45; font-size: 1.5rem;">
        <i class="fas fa-chevron-left"></i>
    </a>
</div>

<section class="hero-tentang">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="fw-bold mb-3">Tentang Kami</h1>
        <p class="fs-6 fw-light mb-0" style="max-width: 600px;">
            Kami memungkinkan para customer untuk mengakses kamar Hotel – semua tersedia di website Roomly.
        </p>
    </div>
</section>

<section class="content-tentang">
    <div class="container">
        
        <div class="row align-items-center mb-5 pb-4">
            <div class="col-md-6 mb-4 mb-md-0 px-lg-4">
                <img src="{{ asset('assets/img/hotel2.png') }}" class="img-fluid rounded-3 shadow-sm" alt="Aston Hotel Solo">
            </div>
            <div class="col-md-6 px-lg-4">
                <p class="history-text fw-medium">
                    Roomly adalah platform booking kamar hotel online, menawarkan konsumen kemudahan memesan kamar. Dengan pilihan kamar yang bervariasi, mulai dari single, hingga deluxe. Selain itu, pengguna tidak terlalu membuang banyak waktu, karena lewat Roomly, pemesanan kamar hanya berlangsung 5 menit, tanpa harus menuju hotel. Bisa dilakukan kapan saja dan dimana saja.
                </p>
            </div>
        </div>

        <div class="row align-items-center mb-5 pb-5 border-bottom">
            <div class="col-md-6 order-2 order-md-1 px-lg-4">
                <p class="history-text fw-medium mb-0">
                    Didirikan di Indonesia pada tahun 2026, Roomly kini bisa di akses di semua perangkat pintar Anda. Menawarkan layanan pelanggan dalam bahasa lokal selama 24 jam setiap hari dengan penyediaan lebih dari 40 metode pembayaran. Roomly telah diakses lebih dari 139 juta kali dan memiliki lebih dari 49 juta pengguna aktif setiap bulan. Untuk informasi lebih lengkap, kunjungi Roomly.
                </p>
            </div>
            <div class="col-md-6 order-1 order-md-2 text-center mb-4 mb-md-0 px-lg-4">
                <img src="{{ asset('assets/img/icons/logo.svg') }}" style="width: 180px;" alt="Logo Roomly">
            </div>
        </div>

        <div class="text-center mb-5 mt-5">
            <h3 class="fw-bold text-dark">Memajukan Ekosistem Perjalanan</h3>
        </div>

        <div class="row text-center px-lg-5">
            <div class="col-md-4 mb-4">
                <img src="{{ asset('assets/img/icons/icon-swag.png') }}" class="ecosystem-icon" alt="Pelanggan">
                <h6 class="fw-bold mt-2 mb-3">Memudahkan Pelanggan</h6>
                <p class="text-muted" style="font-size: 12px; line-height: 1.6; padding: 0 15px;">
                    Memberikan pengalaman reservasi terbaik dan personal untuk seluruh pelanggan melalui produk dan layanan berbasis teknologi
                </p>
            </div>
            <div class="col-md-4 mb-4">
                <img src="{{ asset('assets/img/icons/icon-bumi.png') }}" class="ecosystem-icon" alt="Masyarakat">
                <h6 class="fw-bold mt-2 mb-3">Memberdayakan Masyarakat</h6>
                <p class="text-muted" style="font-size: 12px; line-height: 1.6; padding: 0 15px;">
                    Menerapkan kegiatan dan inisiatif yang bermanfaat dengan prioritas memberikan dampak sosial dan ekonomi yang positif kepada masyarakat lokal
                </p>
            </div>
            <div class="col-md-4 mb-4">
                <img src="{{ asset('assets/img/icons/icon-ponsel.png') }}" class="ecosystem-icon" alt="Kolaborasi">
                <h6 class="fw-bold mt-2 mb-3">Memperkuat Kolaborasi</h6>
                <p class="text-muted" style="font-size: 12px; line-height: 1.6; padding: 0 15px;">
                    Membangun kerjasama strategis untuk terus memperkaya ekosistem travel yang dinamis
                </p>
            </div>
        </div>

    </div>
</section>

@include('layouts.footer')

@endsection