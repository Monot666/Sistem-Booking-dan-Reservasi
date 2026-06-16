@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endpush

@section('content')
<div class="login-wrapper">
    <div class="glass-card">
        <h2 class="font-serif mb-4">Reset Password</h2>
        <p class="mb-4">Masukkan password baru Anda.</p>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group-custom">
                <label>Email</label>
                <input type="email" name="email" class="input-dark" value="{{ $email ?? old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group-custom">
                <label>Password Baru</label>
                <input type="password" name="password" class="input-dark" placeholder="Minimal 6 karakter" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group-custom">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="input-dark" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn-login-submit">Reset Password</button>
        </form>
    </div>
</div>
@endsection
