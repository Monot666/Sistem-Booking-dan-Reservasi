@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4" style="max-width: 1440px;">
    
    <div class="profile-page-title mb-4">
        <a href="{{ route('home') }}"><i class="fa-solid fa-angle-left"></i></a>
        <h2>Profil</h2>
    </div>

    <form id="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            
            <div class="col-md-4 col-lg-3">
                @include('layouts.sidebar_profile')
            </div>

            <div class="col-md-8 col-lg-9">
                <div class="profile-card form-content-area">
                    <h4 class="section-title">Personal Data</h4>

                    {{-- Status Verifikasi --}}
                    @if (!Auth::user()->hasVerifiedEmail())
                        <div class="alert alert-warning border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-1">Akun Belum Terverifikasi</h6>
                                    <p class="small mb-2">Silakan verifikasi akun Anda untuk dapat melakukan pemesanan kamar.</p>
                                    <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-warning fw-bold px-3">Verifikasi Sekarang</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 12px;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-0">Akun Terverifikasi</h6>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
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
                                    @php $bDay = Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->format('j') : 1; @endphp
                                    <select name="birth_day" class="form-select custom-input">
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{ $i }}" {{ old('birth_day', $bDay) == $i ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-4">
                                    @php $bMonth = Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->format('F') : 'January'; @endphp
                                    <select name="birth_month" class="form-select custom-input">
                                        @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                                            <option value="{{ $month }}" {{ old('birth_month', $bMonth) == $month ? 'selected' : '' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    @php $bYear = Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->format('Y') : date('Y'); @endphp
                                    <select name="birth_year" class="form-select custom-input">
                                        @for ($y = date('Y'); $y >= 1950; $y--)
                                            <option value="{{ $y }}" {{ old('birth_year', $bYear) == $y ? 'selected' : '' }}>{{ $y }}</option>
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

                </div>
            </div>

        </div>
    </form> 
</div>
@endsection