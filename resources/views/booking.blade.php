@extends('layouts.app')

@section('content')
<section class="booking-page">
    <div class="booking-overlay"></div>
    <div class="booking-container">
        <div class="booking-header">
            <button class="booking-back" color="Gold" type="button" onclick="window.history.back()">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <h2>Pilih Tanggal Reservasi Anda</h2>
        </div>

        <div class="booking-panel">
            <div class="booking-form-row">
                <div class="booking-field booking-field--wide">
                    <label class="booking-field__label" for="date-range">Check-in & Check-out Dates</label>
                    <div class="booking-input">
                        <img src="{{ asset('assets/img/icons/calender.svg') }}" alt="Calendar">
                        <input type="text" id="date-range" readonly placeholder="12 Mar 2026 - 13 Mar 2026">
                    </div>
                </div>

                <div class="booking-field booking-field--wide">
                    <label class="booking-field__label" for="guest-room">Guests and Rooms</label>
                    <div class="booking-input">
                        <img src="{{ asset('assets/img/icons/user.svg') }}" alt="Guests">
                        <input type="text" id="guest-room" readonly placeholder="2 Adult(s), 0 Child, 1 Room">
                    </div>
                </div>

                <button class="btn btn-gold booking-search-button" type="button">
                    <img src="{{ asset('assets/img/icons/search.svg') }}" alt="Search">
                </button>
            </div>
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
