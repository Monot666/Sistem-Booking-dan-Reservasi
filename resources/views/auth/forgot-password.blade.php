@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@endpush

@section('content')
<div class="login-wrapper">
    <div class="glass-card">
        <h2 class="font-serif mb-4">Lupa Password</h2>
        <p class="mb-4">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="form-group-custom">
                <label>Email</label>
                <input type="email" name="email" class="input-dark" placeholder="email@example.com" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-login-submit">Kirim Link Reset Password</button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="btn-link">Kembali ke Login</a>
        </div>
    </div>
</div>
@endsection
