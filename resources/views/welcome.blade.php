@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<section class="hero-section">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-5 d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="Logo">
            </a>
            
            <div class="nav-right-buttons d-flex align-items-center">
                <a href="{{ url('/send-tester') }}" class="btn btn-outline-light me-3 btn-sm">
                    📧 Kirim Report User
                </a>
                @auth
                    {{-- Tampilan saat User SUDAH Login --}}
                    <div class="user-profile-nav d-flex align-items-center">
                        <a href="{{ route('profile') }}" class="d-flex align-items-center text-decoration-none profile-link">
                            <span class="text-white me-3 fw-light">Hi, {{ Auth::user()->name }}</span>
                            <div class="avatar-circle">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </a>
                        
                        <form action="{{ route('logout') }}" method="POST" class="ms-3">
                            @csrf
                            <button type="submit" class="btn-logout-minimal" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Tampilan saat User BELUM Login --}}
                    <a href="{{ route('login') }}" class="btn-login-outline me-3">Login</a> 
                    <a href="{{ route('register') }}" class="btn btn-gold">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="hero-text-wrapper">
                    <h1 class="hero-title font-serif">Welcome To <br> Roomly</h1>
                    <p class="hero-description">
                        Selamat datang di website Roomly, dimana kamu bisa memesan kamar yang mewah dan elegan. 
                        Yang pastinya cocok untuk melepas penat Anda, bahkan keluarga dan pasangan Anda.
                    </p>
                    <a href="{{ route('booking') }}" class="btn btn-gold btn-lg px-5">BOOK NOW</a>
                </div>

                <div class="hero-divider"></div>

                <div class="row g-0">
                    <div class="col-md-4 room-type-item">
                        <div class="icon-container">
                            <img src="{{ asset('assets/img/icons/icon_superior.svg') }}" alt="Superior">
                        </div>
                        <h6>Superior Rooms</h6>
                        <p>Kamar yang memiliki harga terjangkau, cocok untuk tempat transit agar perjalananmu selanjutnya, badan kamu merasa lebih segar</p>
                    </div>

                    <div class="col-md-4 room-type-item divider-left">
                        <div class="icon-container">
                            <img src="{{ asset('assets/img/icons/icon_deluxe.svg') }}" alt="Deluxe">
                        </div>
                        <h6>Deluxe Suites</h6>
                        <p>Kamar yang memiliki harga terjangkau, cocok untuk tempat transit agar perjalananmu selanjutnya, badan kamu merasa lebih segar</p>
                    </div>

                    <div class="col-md-4 room-type-item divider-left">
                        <div class="icon-container">
                            <img src="{{ asset('assets/img/icons/icon_executive.svg') }}" alt="Executive">
                        </div>
                        <h6>Executive Rooms</h6>
                        <p>Kamar yang memiliki harga terjangkau, cocok untuk tempat transit agar perjalananmu selanjutnya, badan kamu merasa lebih segar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white text-center">
    <div class="container py-4">
        <h2 class="section-title font-serif mb-5 text-dark">Magnificent Building</h2>
        <div class="row g-4">
            <!-- Gambar 1 -->
            <div class="col-md-3 hotel-card">
                <div class="hotel-wrapper">
                    <img src="{{ asset('assets/img/hotel_aston 1.png') }}" alt="Gedung">
                    <div class="hotel-overlay">
                        <div class="hotel-text">Gedung Hotel</div>
                    </div>
                </div>
            </div>

            <!-- Gambar 2 -->
            <div class="col-md-3 hotel-card">
                <div class="hotel-wrapper">
                    <img src="{{ asset('assets/img/aston-solo-hotel.jpg') }}" alt="Kamar">
                    <div class="hotel-overlay">
                        <div class="hotel-text">Kamar Hotel</div>
                    </div>
                </div>
            </div>

            <!-- Gambar 3 -->
            <div class="col-md-3 hotel-card">
                <div class="hotel-wrapper">
                    <img src="{{ asset('assets/img/1d3b438d_z.jpg') }}" alt="Lobby">
                    <div class="hotel-overlay">
                        <div class="hotel-text">Lobby Hotel</div>
                    </div>
                </div>
            </div>

            <!-- Gambar 4 -->
            <div class="col-md-3 hotel-card">
                <div class="hotel-wrapper">
                    <img src="{{ asset('assets/img/images (1).jpg') }}" alt="Swimming Pool">
                    <div class="hotel-overlay">
                        <div class="hotel-text">Swimming Pool</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white text-center">
    <div class="container pb-5">
        <h2 class="section-title font-serif mb-5 text-dark">Hotels Services</h2>
        <div class="row g-5">
            @php
                $services = [
                    ['img' => 'icon_housekeeping.svg', 'title' => 'Housekeeping', 'desc' => 'Pembersihan kamar harian, penggantian handuk.'],
                    ['img' => 'jam.svg', 'title' => 'Resepsionis 24 Hours', 'desc' => 'Melayani check-in dan check-out kapan saja.'],
                    ['img' => 'icon_welcome_drink.svg', 'title' => 'Welcome Drink', 'desc' => 'Minuman selamat datang saat kedatangan.'],
                    ['img' => 'icon_parkir.svg', 'title' => 'Parking', 'desc' => 'Tempat parkir kendaraan luas dan aman.'],
                    ['img' => 'bathroom.svg', 'title' => 'Amenities Bathroom', 'desc' => 'Sabun, sampo, sikat gigi, dan handuk lengkap.'],
                    ['img' => 'icon_wifi.svg', 'title' => 'Free Wi-Fi', 'desc' => 'Koneksi internet di kamar maupun area publik.']
                ];
            @endphp

            @foreach($services as $service)
            <div class="col-md-4 service-item d-flex flex-column align-items-center">
                <div class="icon-container-dark mb-3">
                    <img src="{{ asset('assets/img/icons/'.$service['img']) }}" alt="{{ $service['title'] }}" width="40">
                </div>
                <h5 class="fw-bold mt-2 text-dark">{{ $service['title'] }}</h5>
                <p class="text-muted small px-3">{{ $service['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<footer class="footer py-4" style="background-color: #8C5E23; color: #ffffff;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-logo mb-2">
                    <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="Roomly Logo" width="170">
                </div>
                
                <h5 class="fw-bold mb-3 text-white">Partner Pembayaran</h5>
                
                <div class="row g-2 align-items-center" style="max-width: 340px;">
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_bca.png') }}" alt="BCA">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_mandiri.png') }}" alt="Mandiri">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_bri.png') }}" alt="BRI">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_bni.png') }}" alt="BNI">
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_cimb.svg') }}" alt="CIMB">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_atm_bersama.png') }}" alt="ATM Bersama">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_prima.png') }}" alt="Prima">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_alto.png') }}" alt="Alto">
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_link.png') }}" alt="LinkAja">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_visa.png') }}" alt="Visa">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_mastercard.png') }}" alt="Mastercard">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_jcb.png') }}" alt="JCB">
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_amex.png') }}" alt="Amex">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_alfamart.png') }}" alt="Alfamart">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_alfamidi.png') }}" alt="Alfamidi">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_indomaret.png') }}" alt="Indomaret">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <h5 class="fw-bold mb-3 text-white">Tentang Roomly</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none opacity-75">Cara Pesan</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none opacity-75">Hubungi Kami</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none opacity-75">Pusat Bantuan</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none opacity-75">Tentang Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="fw-bold mb-3 text-white">Follow kami di</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/logo_facebook.svg') }}" width="20" class="me-2" alt="Facebook"> Facebook
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/logo_instagram.svg') }}" width="20" class="me-2" alt="Instagram"> Instagram
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/logo_tiktok.svg') }}" width="20" class="me-2" alt="Tiktok"> Tiktok
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/logo_whatsapp.svg') }}" width="20" class="me-2" alt="WhatsApp"> WhatsApp
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3 text-white">Lainnya</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none opacity-75">Pemberitahuan Privasi</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none opacity-75">Syarat & Ketentuan</a></li>
                </ul>
            </div>

        </div>

        <div class="text-center mt-5 text-white-50 border-top pt-3" style="border-color: rgba(255,255,255,0.1) !important;">
            <p class="mb-0">&copy; 2026 Roomly. All Rights Reserved.</p>
        </div>
    </div>
</footer>
@endsection
