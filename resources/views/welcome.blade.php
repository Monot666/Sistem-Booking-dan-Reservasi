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
                    <a href="{{ route('login') }}" class="btn text-white me-3 text-decoration-none">Login</a> 
                    <a href="{{ route('register') }}" class="btn btn-gold">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="hero-title font-serif">Welcome To <br> Roomly</h1>
                <p class="text-white-50 fs-5 mb-4" style="max-width: 600px;">
                    Selamat datang di website Roomly, dimana kamu bisa memesan kamar yang mewah dan elegan. 
                    Yang pastinya cocok untuk melepas penat Anda, bahkan keluarga dan pasangan Anda.
                </p>
                <a href="#" class="btn btn-gold btn-lg px-5">BOOK NOW</a>
                
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
        <h2 class="section-title font-serif mb-5 text-dark">Wide Choice of Hotels</h2>
        <div class="row g-4">
            <div class="col-md-3 hotel-card"><img src="{{ asset('assets/img/fave_hotel 1.png') }}" alt="Hotel 1"></div>
            <div class="col-md-3 hotel-card"><img src="{{ asset('assets/img/hotel_aston 1.png') }}" alt="Hotel 2"></div>
            <div class="col-md-3 hotel-card"><img src="{{ asset('assets/img/novotel 1.png') }}" alt="Hotel 3"></div>
            <div class="col-md-3 hotel-card"><img src="{{ asset('assets/img/Rectangle 1.png') }}" alt="Hotel 4"></div>
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

<footer class="footer">
    <div class="container text-start">
        <div class="row g-4">
            <div class="col-lg-4">
                <h5 class="footer-title text-uppercase mb-3" style="color: var(--gold-primary);">contact us</h5>
                <div class="social-icons">
                    <a href="#" class="text-white me-3 fs-4"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white fs-4"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <div class="text-center mt-5 text-white-50 border-top pt-3">
            <p>&copy; 2026 Roomly. All Rights Reserved.</p>
        </div>
    </div>
</footer>
@endsection