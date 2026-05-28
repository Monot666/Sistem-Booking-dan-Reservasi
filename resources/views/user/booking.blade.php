@extends('layouts.app')

@section('content')
<section class="booking-page">
    <div class="booking-overlay"></div>
    <div class="booking-container">
        
        <div class="booking-header">
            <button class="booking-back" type="button" onclick="window.history.back()">
                &lt;
            </button>
            <h2 class="booking-title">Pilih Tanggal Reservasi Anda</h2>
        </div>

        <div class="booking-panel">
            <form id="booking-search-form" method="GET" action="{{ route('pilih-kamar') }}">
                <div class="booking-form-row">
                    
                    <div class="booking-field booking-field--wide">
                        <label class="booking-field__label" for="date-range">Tanggal Check-in & Check-out</label>
                        <div class="booking-input">
                            <img src="{{ asset('assets/img/icons/calender.svg') }}" alt="Calendar">
                            <input type="text" id="date-range" readonly placeholder="12 Mar 2026 - 13 Mar 2026">
                            <input type="hidden" name="checkin" id="checkin">
                            <input type="hidden" name="checkout" id="checkout">
                        </div>
                    </div>

                    <div class="booking-field booking-field--wide">
                        <label class="booking-field__label" for="guest-room">Tamu dan Kamar</label>
                        <div class="booking-input">
                            <img src="{{ asset('assets/img/icons/user.svg') }}" alt="Guests">
                            <input type="text" id="guest-room" readonly placeholder="2 Adult(s), 0 Child, 1 Room">
                            <input type="hidden" name="guests" id="guests" value="2">
                            <input type="hidden" name="rooms" id="rooms" value="1">
                        </div>
                    </div>

                    <button class="btn btn-gold booking-search-button" type="submit">
                        <i class="fa-solid fa-search"></i>
                        <span>Cari Kamar</span>
                    </button>
                    
                </div>
            </form>
        </div>

        <div class="booking-ad">
            <img src="{{ asset('assets/img/novotel 1.png') }}" alt="Promo Novotel">
        </div>
        
    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="{{ asset('assets/js/booking.js') }}"></script>
@endpush