@extends('layouts.app')

@section('content')
<section class="booking-page">
    <div class="booking-overlay"></div>
    <div class="booking-container">
        
        <div class="booking-header">
            <a href="{{ route('home') }}" class="booking-back-link">
                <i class="fa-solid fa-chevron-left"></i> Pilih Tanggal Reservasi Anda
            </a>
        </div>
    </div>

    <div class="booking-gold-line"></div>

    <div class="booking-container">
        <div class="booking-panel">
            <form id="booking-search-form" method="GET" action="{{ route('rooms.index') }}">
                <div class="booking-search-bar">
                    
                    <div class="booking-search-field border-right-divider">
                        <label for="date-range">Check-in & Check-out Dates</label>
                        <div class="booking-input-wrapper">
                            <i class="fa-solid fa-calendar-days icon-orange"></i>
                            <input type="text" id="date-range" readonly placeholder="12 Mar 2026 - 13 Mar 2026">
                            <input type="hidden" name="checkin" id="checkin">
                            <input type="hidden" name="checkout" id="checkout">
                        </div>
                    </div>

                    <div class="booking-search-field">
                        <label for="guest-room">Guests and Rooms</label>
                        <div class="booking-input-wrapper">
                            <i class="fa-solid fa-user icon-orange"></i>
                            <input type="text" id="guest-room" readonly value="2 Adult(s), 0 Child, 1 Room">
                            <input type="hidden" name="guests" id="guests" value="2">
                            <input type="hidden" name="rooms" id="rooms" value="1">
                        </div>
                    </div>

                    <button class="booking-btn-search" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    
                </div>
            </form>
        </div>

        <div class="booking-ad">
            <img src="{{ asset('assets/img/novotel 1.png') }}" alt="Promo Properti">
        </div>
        
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}?v={{ time() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('assets/js/booking.js') }}?v={{ time() }}"></script>
@endpush