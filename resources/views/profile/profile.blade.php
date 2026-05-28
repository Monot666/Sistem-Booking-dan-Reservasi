@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4" style="max-width: 1440px;">
    
    <div class="profile-page-title mb-4">
        <a href="javascript:history.back()"><i class="fa-solid fa-angle-left"></i></a>
        <h2>Profil</h2>
    </div>

    <div class="row g-4">
        
        <div class="col-md-4 col-lg-3">
            @include('layouts.sidebar_profile')
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="profile-card form-content-area">
                <h4 class="section-title">Personal Data</h4>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="custom-label">Full Name</label>
                        <input type="text" name="name" class="form-control custom-input @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name ?? '') }}">
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="custom-label">Gender</label>
                            <select name="gender" class="form-select custom-input">
                                <option value="Male" {{ old('gender', Auth::user()->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', Auth::user()->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <div class="col-md-8">
                            <label class="custom-label">Birthdate</label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <select name="birth_day" class="form-select custom-input">
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{ $i }}" {{ old('birth_day', Auth::user()->birth_day ?? 1) == $i ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="birth_month" class="form-select custom-input">
                                        @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                                            <option value="{{ $month }}" {{ old('birth_month', Auth::user()->birth_month ?? 'January') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="birth_year" class="form-select custom-input">
                                        @for ($y = date('Y'); $y >= 1950; $y--)
                                            <option value="{{ $y }}" {{ old('birth_year', Auth::user()->birth_year ?? '2001') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="custom-label">City of Residence</label>
                        <input type="text" name="city" class="form-control custom-input @error('city') is-invalid @enderror" value="{{ old('city', Auth::user()->city ?? '') }}">
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="custom-label">Email</label>
                            <input type="email" name="email" class="form-control custom-input @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="custom-label">Mobile Number</label>
                            <input type="text" name="phone" class="form-control custom-input @error('phone') is-invalid @enderror" value="{{ old('phone', Auth::user()->phone ?? '') }}">
                        </div>
                    </div>

                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-save">Save</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection