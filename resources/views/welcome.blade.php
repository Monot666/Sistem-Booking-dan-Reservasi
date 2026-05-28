@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

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
                    {{-- Tampilan Profil Profesional saat User SUDAH Login --}}
                    <a href="{{ route('profile') }}" class="nav-profile-pill">
                        <span class="nav-greeting">Hi, {{ strtok(Auth::user()->name, " ") }}</span>
                        <div class="nav-avatar">
                            @if(Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="Avatar">
                            @else
                                <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                        </div>
                    </a>
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
        <h2 class="section-title font-serif mb-5 text-dark">Wide Choice of Hotels</h2>
        <div class="row g-4">
            <div class="col-md-3 hotel-card">
                <div class="hotel-wrapper">
                    <img src="{{ asset('assets/img/hotel_aston 1.png') }}" alt="Gedung">
                    <div class="hotel-overlay">
                        <div class="hotel-text">Gedung Hotel</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 hotel-card">
                <div class="hotel-wrapper">
                    <img src="{{ asset('assets/img/aston-solo-hotel.jpg') }}" alt="Kamar">
                    <div class="hotel-overlay">
                        <div class="hotel-text">Kamar Hotel</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 hotel-card">
                <div class="hotel-wrapper">
                    <img src="{{ asset('assets/img/1d3b438d_z.jpg') }}" alt="Lobby">
                    <div class="hotel-overlay">
                        <div class="hotel-text">Lobby Hotel</div>
                    </div>
                </div>
            </div>

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

<section class="py-2 bg-white">
    <div class="container">
        
        <!-- Benefit Boxes -->
        <div class="row g-4 mt-2">
            <div class="col-md-4">
                <div class="benefit-box">
                    <div class="benefit-icon"><i class="fa-regular fa-calendar-check"></i></div>
                    <div class="benefit-text">
                        <h6>Refund & reschedule mudah</h6>
                        <p>Lebih mudah batalkan atau ubah pesanan hotel kamu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="benefit-box">
                    <div class="benefit-icon"><i class="fa-solid fa-car-side"></i></div>
                    <div class="benefit-text">
                        <h6>Perjalanan yang Mudah</h6>
                        <p>Keuntungan eksklusif, diskon, dan fasilitas tambahan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="benefit-box">
                    <div class="benefit-icon"><i class="fa-solid fa-headset"></i></div>
                    <div class="benefit-text">
                        <h6>Pusat bantuan 24/7</h6>
                        <p>Hubungi kami kapan pun Anda membutuhkan bantuan.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="ad-banner">
            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=1200&q=80" alt="Banner Iklan Roomly">
        </div>

    </div>
</section>

<section class="py-5 bg-white text-center">
    <div class="container pb-2">
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

<section class="py-5 bg-white">
    <div class="container pb-5">
        <h4 class="extra-section-title">Kami tidak hanya menyediakan kamar</h4>
        <div class="row g-4">
            
            <div class="col-md-4">
                <a href="https://example.com/wisata" target="_blank" class="extra-card">
                    <img src="{{ asset('assets/img/wisata-solo.png') }}" alt="Wisata Solo">
                    <div class="extra-overlay">
                        <h6>Wisata terbaik di Solo</h6>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="https://example.com/resep" target="_blank" class="extra-card">
                    <img src="{{ asset('assets/img/makanan-oriental.png') }}" alt="Makanan">
                    <div class="extra-overlay">
                        <h6>Resep makanan enak</h6>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="https://example.com/ikan" target="_blank" class="extra-card">
                    <img src="{{ asset('assets/img/ikan-sapu.png') }}" alt="Menimbun Ikan">
                    <div class="extra-overlay">
                        <h6>Cara menimbun ikan</h6>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>

@include('layouts.footer')
@endsection