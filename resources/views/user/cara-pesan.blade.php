@extends('layouts.app')

@section('content')
<!-- Memanggil file CSS eksternal khusus Cara Pesan -->
<link href="{{ asset('assets/css/cara-pesan.css') }}" rel="stylesheet">

<!-- ================= 1. BAGIAN HERO (ATAS) ================= -->
<section class="hero-cara-pesan">
    <!-- Overlay Gelap -->
    <div class="hero-overlay"></div>
    
    <!-- Tombol Kembali Kiri Atas -->
    <a href="{{ route('landing') }}" class="btn-back-gold">
        <i class="fas fa-chevron-left"></i>
    </a>
    
    <!-- Teks Tengah -->
    <div class="hero-content">
        <h1 class="fw-bold mb-3">Cara Pesan Kamar di Roomly</h1>
        <p class="fs-5 fw-light">Booking kamar Anda hanya dalam 5 menit!</p>
    </div>
</section>

<!-- ================= 2. BAGIAN LANGKAH-LANGKAH (SCROLL KE BAWAH) ================= -->
<section class="container py-5 my-4">
    
    <!-- Langkah 1 -->
    <div class="row align-items-center mb-5 pb-3">
        <div class="col-md-6 mb-4 mb-md-0 px-4">
            <img src="{{ asset('assets/img/cara-pesan1.png') }}" class="img-fluid rounded-4 shadow-sm w-100 border" alt="Langkah 1: Klik Book Now">
        </div>
        <div class="col-md-6 px-4">
            <div class="step-card">
                <div class="step-number">1</div>
                <div>
                    <h5 class="fw-bold mb-2">Klik "Book Now"</h5>
                    <p class="text-muted mb-0 small lh-lg">Mulai pemesanan kamar Anda dengan menekan tombol "book now".</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Langkah 2 -->
    <div class="row align-items-center mb-5 pb-3">
        <div class="col-md-6 mb-4 mb-md-0 px-4">
            <img src="{{ asset('assets/img/cara-pesan2.png') }}" class="img-fluid rounded-4 shadow-sm w-100 border" alt="Pilih Tanggal & Jumlah Tamu">
        </div>
        <div class="col-md-6 px-4">
            <div class="step-card">
                <div class="step-number">2</div>
                <div>
                    <h5 class="fw-bold mb-2">Pilih tanggal & jumlah tamu</h5>
                    <p class="text-muted mb-0 small lh-lg">Masukkan tanggal check-in & check-out serta jumlah tamu yang akan menginap.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Langkah 3 -->
    <div class="row align-items-center mb-5 pb-3">
        <div class="col-md-6 mb-4 mb-md-0 px-4">
            <img src="{{ asset('assets/img/cara-pesan3.png') }}" class="img-fluid rounded-4 shadow-sm w-100 border" alt="Pilih Kamar">
        </div>
        <div class="col-md-6 px-4">
            <div class="step-card">
                <div class="step-number">3</div>
                <div>
                    <h5 class="fw-bold mb-2">Pilih kamar</h5>
                    <p class="text-muted mb-0 small lh-lg">Pilih kamar yang cocok untukmu, deskripsi kamar juga tertera di halaman.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Langkah 4 -->
    <div class="row align-items-center mb-5 pb-3">
        <div class="col-md-6 mb-4 mb-md-0 px-4">
            <img src="{{ asset('assets/img/cara-pesan4.png') }}" class="img-fluid rounded-4 shadow-sm w-100 border" alt="Isi Data Pemesan">
        </div>
        <div class="col-md-6 px-4">
            <div class="step-card">
                <div class="step-number">4</div>
                <div>
                    <h5 class="fw-bold mb-2">Isi data pemesan</h5>
                    <p class="text-muted mb-0 small lh-lg">Isi semua data dalam form yang sudah disediakan, disini Anda juga bisa melihat total biaya yang harus dibayarkan.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Langkah 5 -->
    <div class="row align-items-center mb-5 pb-3">
        <div class="col-md-6 mb-4 mb-md-0 px-4">
            <img src="{{ asset('assets/img/cara-pesan5.png') }}" class="img-fluid rounded-4 shadow-sm w-100 border" alt="Lakukan Pembayaran">
        </div>
        <div class="col-md-6 px-4">
            <div class="step-card">
                <div class="step-number">5</div>
                <div>
                    <h5 class="fw-bold mb-2">Lakukan Pembayaran</h5>
                    <p class="text-muted mb-0 small lh-lg">Beragam metode pembayaran tersedia. Pilihlah yang sesuai kebutuhan Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Langkah 6 -->
    <div class="row align-items-center mb-5 pb-3">
        <div class="col-md-6 mb-4 mb-md-0 px-4">
            <div class="step-image-placeholder">Gambar UI - Step 6</div>
        </div>
        <div class="col-md-6 px-4">
            <div class="step-card">
                <div class="step-number">6</div>
                <div>
                    <h5 class="fw-bold mb-2">Pemesanan Berhasil</h5>
                    <p class="text-muted mb-0 small lh-lg">Pesanan Anda telah berhasil</p>
                </div>
            </div>
        </div>
    </div>

</section>
@include('layouts.footer')
@endsection