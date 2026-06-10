@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/ewallet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4" style="max-width: 1440px;">
    
    <div class="profile-page-title mb-4">
        <a href="{{ route('home') }}"><i class="fa-solid fa-angle-left"></i></a>
        <h2>E-Wallet Saya</h2>
    </div>

    <div class="row g-4">
        <div class="col-md-4 col-lg-3">
            @include('layouts.sidebar_profile')
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="profile-card form-content-area">
                <h4 class="section-title">Daftar E-Wallet</h4>
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row g-3">
                    @foreach($wallets ?? [] as $wallet)
                        @include('profile.components.ewallet-card', ['wallet' => $wallet])
                    @endforeach

                    @for($i = count($wallets ?? []); $i < 6; $i++)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="ewallet-card add" onclick="openAddModal()" style="cursor: pointer; border: 2px dashed #e2e8f0; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; min-height: 120px; border-radius: 8px; color: #df9e38;">
                            <i class="fas fa-plus-circle mb-2" style="font-size: 1.5rem;"></i>
                            <span style="font-size: 0.85rem; font-weight: 500;">Tambah E-Wallet</span>
                        </div>
                    </div>
                    @endfor
                </div>

            </div>
        </div>
    </div>
</div>

@include('profile.components.modal-add-ewallet')
@include('profile.components.modal-edit-ewallet')

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/ewallet.js') }}"></script>
@endpush