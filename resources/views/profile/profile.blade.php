@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')
<div class="container profile-container mt-4">
    <div class="row">

        {{-- ===================== SIDEBAR ===================== --}}
        <div class="col-md-3">
            @include('layouts.sidebar_profile')
        </div>

        {{-- ===================== MAIN CONTENT ===================== --}}
        <div class="col-md-9">
            <div class="glass-card p-4 shadow-sm">
                <h5 class="fw-bold mb-3">Personal Data</h5>
                <hr class="mb-4">

                {{-- Success / Error Alert --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- Full Name --}}
                        <div class="col-12 mb-1">
                            <label class="small text-muted mb-1">Full Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control input-custom @error('name') is-invalid @enderror"
                                   value="{{ old('name', Auth::user()->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gender --}}
                        <div class="col-md-3 mb-1">
                            <label class="small text-muted mb-1">Gender</label>
                            <select name="gender" class="form-select input-custom">
                                <option value="Male"   {{ old('gender', Auth::user()->gender) == 'Male'   ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', Auth::user()->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        {{-- Birthdate: Day --}}
                        <div class="col-md-3 mb-1">
                            <label class="small text-muted mb-1">Birthdate</label>
                            <select name="birth_day" class="form-select input-custom">
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('birth_day', Auth::user()->birth_day ?? 1) == $i ? 'selected' : '' }}>
                                        {{ sprintf('%02d', $i) }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Birthdate: Month --}}
                        <div class="col-md-3 mb-1">
                            <label class="small text-muted mb-1">&nbsp;</label>
                            <select name="birth_month" class="form-select input-custom">
                                @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                                    <option value="{{ $month }}"
                                        {{ old('birth_month', Auth::user()->birth_month ?? 'January') == $month ? 'selected' : '' }}>
                                        {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Birthdate: Year --}}
                        <div class="col-md-3 mb-1">
                            <label class="small text-muted mb-1">&nbsp;</label>
                            <input type="number"
                                   name="birth_year"
                                   class="form-control input-custom @error('birth_year') is-invalid @enderror"
                                   value="{{ old('birth_year', Auth::user()->birth_year ?? '2001') }}"
                                   min="1900" max="{{ date('Y') }}">
                            @error('birth_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- City of Residence --}}
                        <div class="col-12 mb-1">
                            <label class="small text-muted mb-1">City of Residence</label>
                            <input type="text"
                                   name="city"
                                   class="form-control input-custom @error('city') is-invalid @enderror"
                                   value="{{ old('city', Auth::user()->city ?? '') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-1">
                            <label class="small text-muted mb-1">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control input-custom @error('email') is-invalid @enderror"
                                   value="{{ old('email', Auth::user()->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Mobile Number --}}
                        <div class="col-md-6 mb-1">
                            <label class="small text-muted mb-1">Mobile Number</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control input-custom @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', Auth::user()->phone ?? '') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Save Button --}}
                        <div class="col-12 text-end mt-3">
                            <button type="submit" class="btn btn-save px-5">Save</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection