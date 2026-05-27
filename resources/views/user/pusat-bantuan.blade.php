@extends('layouts.app')

@section('content')
<link href="{{ asset('assets/css/hubungi-kami.css') }}" rel="stylesheet">

<div class="bg-white py-3 px-4 shadow-sm position-relative" style="z-index: 3;">
    <a href="{{ route('landing') }}" class="text-decoration-none" style="color: #df9e45; font-size: 1.5rem;">
        <i class="fas fa-chevron-left"></i>
    </a>
</div>

<section class="header-hubungi">
    <div class="container">
        <h2 class="fw-bold mb-2">Pusat Bantuan</h2>
        <p class="fs-6 mb-0">Butuh bantuan darurat? Tim Roomly siap sedia untuk Anda.</p>
    </div>
</section>

<section class="content-hubungi">
    <div class="container">

        <div class="row justify-content-center pb-5 pt-3">
            <div class="col-lg-5 col-md-8">
                <div class="chat-card d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/cs-icon.png') }}" alt="Customer Service" class="mb-4" style="width: 90px;">
                    
                    <h5 class="fw-bold mb-3">Live Chat Support</h5>
                    <p class="text-muted mb-4 px-3 text-center" style="font-size: 14px;">
                        Silakan mulai obrolan jika Anda mengalami kendala saat pemesanan atau ingin menanyakan informasi lebih lanjut mengenai Roomly.
                    </p>
                    
                    <button class="btn btn-chat btn-lg w-100 rounded-pill shadow-sm">Mulai Chat Sekarang</button>
                </div>
            </div>
        </div>

    </div>
</section>

@include('layouts.footer')

@endsection