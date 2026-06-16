@extends('layouts.app')

@push('styles')
    {{-- Menggunakan CSS yang sama agar desain konsisten --}}
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endpush

@section('content')
<div class="login-wrapper">
    <a href="{{ url('/login') }}" class="btn-back">
        <i class="fas fa-chevron-left"></i>
    </a>

    <div class="glass-card">
        <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="Roomly" class="login-logo">
        
        <h2 class="font-serif mb-4">Create Account</h2>

        @if ($errors->any())
            <div style="color: #ff4d4f; background: rgba(255, 77, 79, 0.1); border: 1px solid rgba(255, 77, 79, 0.3); padding: 10px 15px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; text-align: center; font-weight: 500;">
                <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group-custom">
                <label>Full Name</label>
                <input type="text" name="name" class="input-dark" placeholder="Nama Lengkap Anda" required value="{{ old('name') }}">
            </div>

            <div class="form-group-custom">
                <label>Email</label>
                <input type="email" name="email" class="input-dark" placeholder="Email Anda" required value="{{ old('email') }}">
            </div>

            <div class="form-group-custom">
                <label>Password</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" class="input-dark" placeholder="Buat Password" required>
                    <i class="fas fa-eye toggle-password" id="eyeIcon"></i>
                </div>
            </div>

            <div class="form-group-custom">
                <label>Konfirmasi Password</label>
                <div class="password-container">
                    <input type="password" name="password_confirmation" class="input-dark" placeholder="Ulangi Password" required>
                </div>
            </div>

            <button type="submit" class="btn-login-submit">Register</button>
        </form>

        <p class="reg-link">
            Already have an account? <a href="{{ url('/login') }}">Login</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/login.js') }}"></script>
@endpush