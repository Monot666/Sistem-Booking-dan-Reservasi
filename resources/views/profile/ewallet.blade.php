@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/ewallet.css') }}">
@endpush

@section('content')
<div class="container profile-container mt-4">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-3">
            @include('layouts.sidebar_profile')
        </div>

        {{-- Content --}}
        <div class="col-md-9">
            <div class="glass-card p-4 shadow-sm">
                <h5 class="fw-bold mb-4">E-Wallet Saya</h5>

                <div class="row g-3">

                    {{-- DATA WALLET --}}
                    @foreach($wallets ?? [] as $wallet)
                        @include('profile.components.ewallet-card', ['wallet' => $wallet])
                    @endforeach

                    {{-- SLOT TAMBAH --}}
                    @for($i = count($wallets ?? []); $i < 6; $i++)
                    <div class="col-md-4">
                        <div class="ewallet-card add" onclick="openAddModal()">
                            <i class="fas fa-plus-circle"></i>
                            <span>Tambah E-Wallet</span>
                        </div>
                    </div>
                    @endfor

                </div>
            </div>
        </div>

    </div>
</div>

{{-- MODALS --}}
@include('profile.components.modal-add-ewallet')
@include('profile.components.modal-edit-ewallet')

@endsection

@push('scripts')
<script src="{{ asset('assets/js/ewallet.js') }}"></script>
@endpush