@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endpush

@section('content')
<div class="login-wrapper">
    <div class="glass-card">
        <h2 class="font-serif mb-4">Verifikasi Email</h2>
        <p class="mb-4">Masukkan 6 digit kode OTP yang telah dikirimkan ke email Anda.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                Kode OTP baru telah dikirim ke email Anda.
            </div>
        @endif

        <form action="{{ route('verification.verify-otp') }}" method="POST">
            @csrf
            <div class="form-group-custom">
                <label>Kode OTP</label>
                <input type="text" name="otp_code" class="input-dark text-center" placeholder="000000" maxlength="6" required autofocus>
                @error('otp_code')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login-submit">Verifikasi</button>
        </form>

        <div class="mt-4">
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button type="submit" class="btn-link">Kirim ulang kode OTP</button>
            </form>
        </div>
    </div>
</div>
@endsection
