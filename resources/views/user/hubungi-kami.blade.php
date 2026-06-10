@extends('layouts.app')

@section('content')
<!-- Memanggil CSS Khusus -->
<link href="{{ asset('assets/css/hubungi-kami.css') }}" rel="stylesheet">

<!-- Navigasi Atas (Putih) -->
<div class="bg-white py-3 px-4 shadow-sm position-relative" style="z-index: 3;">
    <a href="{{ route('home') }}" class="text-decoration-none" style="color: #df9e45; font-size: 1.5rem;">
        <i class="fas fa-chevron-left"></i>
    </a>
</div>

<!-- Header Emas -->
<section class="header-hubungi">
    <div class="container">
        <h2 class="fw-bold mb-2">Hubungi Kami</h2>
        <p class="fs-6 mb-0">Di mana pun Anda berada, kami dapat terhubung hanya dengan satu kali klik!</p>
    </div>
</section>

<!-- Konten Utama (Bentuk Melengkung) -->
<section class="content-hubungi">
    <div class="container">
        <div class="row align-items-center mb-5">
            <!-- Kolom Kiri: Teks Pembuka -->
            <div class="col-lg-6 mb-4 mb-lg-0 pe-lg-5">
                <h1 class="contact-title">Reach out and say hello</h1>
                <p class="text-muted">Silakan pilih pertanyaan di bawah ini. Kami sangat ingin mendengarkan Anda.</p>
            </div>
            
            <!-- Kolom Kanan: Gambar 3D "Hallo" -->
            <div class="col-lg-6 text-center">
                <!-- Pastikan gambar hallo-3d.png sudah ada di folder public/assets/img/ -->
                <img src="{{ asset('assets/img/hallo-3d.png') }}" alt="Hallo" class="img-fluid" style="max-height: 200px;">
            </div>
        </div>

        <div class="row align-items-stretch">
            <!-- Kartu Kiri: FAQ -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="faq-card h-100">
                    <h6 class="fw-bold mb-4" style="font-size: 18px;">Yang sering ditanyakan</h6>
                    
                    <div class="faq-wrapper">
                        <a href="#faq1" class="faq-item" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="faq1">
                            <span>Saya mau reschedule pesanan saya</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <div class="collapse" id="faq1">
                            <div class="faq-answer">
                                Untuk mengubah jadwal (reschedule), silakan masuk ke menu <strong>Pesanan Saya</strong>, pilih reservasi yang ingin diubah, lalu klik tombol <strong>Reschedule</strong>. Pastikan Anda membaca syarat dan ketentuan perubahan jadwal dari hotel terkait.
                            </div>
                        </div>
                    </div>

                    <div class="faq-wrapper">
                        <a href="#faq2" class="faq-item" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="faq2">
                            <span>Update email</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <div class="collapse" id="faq2">
                            <div class="faq-answer">
                                Anda dapat mengubah alamat email yang terdaftar melalui menu <strong>Profil</strong>. Klik <strong>Edit Profil</strong>, masukkan alamat email baru Anda, dan lakukan verifikasi melalui link yang kami kirimkan ke email baru tersebut.
                            </div>
                        </div>
                    </div>

                    <div class="faq-wrapper">
                        <a href="#faq3" class="faq-item" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="faq3">
                            <span>Menambahkan kartu debit/kredit</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <div class="collapse" id="faq3">
                            <div class="faq-answer">
                                Masuk ke menu <strong>Akun Saya</strong>, pilih <strong>Metode Pembayaran</strong>, lalu klik <strong>Tambah Kartu Baru</strong>. Masukkan detail kartu Anda dengan benar. Tenang saja, data Anda dijamin keamanannya oleh sistem enkripsi kami.
                            </div>
                        </div>
                    </div>

                    <div class="faq-wrapper">
                        <a href="#faq4" class="faq-item" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="faq4">
                            <span>Menambahkan E-Wallet</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <div class="collapse" id="faq4">
                            <div class="faq-answer">
                                Pada halaman pembayaran saat melakukan pemesanan, Anda bisa langsung memilih opsi <strong>E-Wallet</strong> (OVO, GoPay, Dana, dll). Anda juga bisa menyambungkan akun E-Wallet di menu pengaturan profil agar pemesanan selanjutnya lebih cepat.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Kartu Kanan: Chat CS -->
            <div class="col-lg-6">
                <div class="chat-card h-100 d-flex flex-column justify-content-center align-items-center">
                    <!-- Pastikan icon cs-icon.png sudah ada di folder public/assets/img/ -->
                    <img src="{{ asset('assets/img/cs-icon.png') }}" alt="Customer Service" class="mb-3" style="width: 120px;">
                    
                    <p class="fw-bold mb-4" style="font-size: 14px; max-width: 250px;">
                        Kamu tetap bisa hubungi kami lewat chat dan pilih opsi yang tersedia.
                    </p>
                    
                    <button class="btn btn-chat">Chat dengan kami</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Global -->
@include('layouts.footer')

@endsection