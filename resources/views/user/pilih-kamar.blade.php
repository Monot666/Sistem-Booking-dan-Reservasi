@extends('layouts.app')

@section('content')
<div class="room-selection-wrapper">
    
    <div class="room-navbar bg-white py-3 px-4 border-bottom shadow-sm">
        <div class="navbar-content container-fluid d-flex align-items-center">
            <a href="{{ route('booking') }}" class="back-link text-decoration-none fw-bold" style="color: #df9e45;">
                <span class="back-arrow me-2">&#10094;</span> PILIH KAMAR
            </a>
        </div>
    </div>

    <div class="room-main-container container py-5">
        
        <div class="bg-white rounded-4 border p-4 mb-5 shadow-sm">
            <div class="row text-center text-md-start g-3 text-sm">
                <div class="col-6 col-md-3 border-end">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Check-in</p>
                    <h5 class="fw-bold text-dark mb-0">{{ request('checkin') ?? '-' }}</h5>
                </div>
                <div class="col-6 col-md-3 border-end">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Check-out</p>
                    <h5 class="fw-bold text-dark mb-0">{{ request('checkout') ?? '-' }}</h5>
                </div>
                <div class="col-6 col-md-3 border-end">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Tamu</p>
                    <h5 class="fw-bold text-dark mb-0">{{ request('guests') ?? '2' }} Orang</h5>
                </div>
                <div class="col-6 col-md-3">
                    <p class="text-muted mb-1 small text-uppercase fw-bold">Kamar</p>
                    <h5 class="fw-bold text-dark mb-0">{{ request('rooms') ?? '1' }} Kamar</h5>
                </div>
            </div>
        </div>
        
        @forelse($resources as $resource)
        <div class="room-card bg-white rounded-4 border p-4 mb-4 shadow-sm">
            <h2 class="room-title fw-bold mb-3" style="color: #df9e45;">{{ $resource->name }}</h2>
            
            <div class="room-card-body row g-4">
                <div class="col-lg-4 col-md-5 d-flex flex-column">
                    <div class="room-image-wrapper mb-3">
                        <img src="{{ $resource->image ?? asset('assets/img/bg.png') }}" alt="{{ $resource->name }}" class="room-img img-fluid rounded-3 w-100 object-cover" style="height: 200px;">
                    </div>
                    
                    <div class="room-spec mb-3">
                        <span class="spec-size fw-bold text-dark">📐 Tipe: {{ $resource->type }}</span>
                    </div>

                    <p class="text-muted small text-justify mb-3">
                        {{ $resource->description }}
                    </p>

                    <div class="room-facilities-grid d-flex flex-wrap gap-2 mb-3 text-muted small">
                        <span class="badge bg-light text-dark p-2 border">🚿 Shower</span>
                        <span class="badge bg-light text-dark p-2 border">❄️ AC</span>
                        <span class="badge bg-light text-dark p-2 border">📶 Free WiFi</span>
                        <span class="badge bg-light text-dark p-2 border">👥 Max {{ $resource->capacity }} Orang</span>
                    </div>
                </div>

                <div class="col-lg-8 col-md-7">
                    <div class="table-responsive border rounded-3">
                        <table class="table prices-table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="50%">Opsi Kamar</th>
                                    <th width="15%" class="text-center">Kapasitas</th>
                                    <th width="20%" class="text-end">Harga / Malam</th>
                                    <th width="15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="option-info p-3">
                                        <span class="sub-title d-block fw-bold text-dark">{{ $resource->name }} - Tanpa Sarapan</span>
                                        <p class="policy-info text-danger small mb-0 mt-1">🔄 Non-Refundable</p>
                                    </td>
                                    <td class="text-center p-3 text-xl">👥</td>
                                    <td class="price-amount text-end p-3 fw-bold text-dark">
                                        Rp {{ number_format($resource->price_per_hour, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center p-3">
                                        <form action="{{ route('user.review') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="room_id" value="{{ $resource->id }}">
                                            <input type="hidden" name="room_name" value="{{ $resource->name }}">
                                            <input type="hidden" name="option_type" value="Room Only">
                                            <input type="hidden" name="price" value="{{ $resource->price_per_hour }}">
                                            <button type="submit" class="btn btn-sm btn-choose text-white px-3 fw-bold" style="background-color: #df9e45;">Pilih</button>
                                        </form>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td class="option-info p-3">
                                        <span class="sub-title d-block fw-bold text-dark">{{ $resource->name }} - Termasuk Sarapan</span>
                                        <p class="policy-info text-success small mb-0 mt-1">✅ Free Cancellation</p>
                                    </td>
                                    <td class="text-center p-3 text-xl">👥</td>
                                    <td class="price-amount text-end p-3 fw-bold text-dark">
                                        Rp {{ number_format($resource->price_per_hour + 75000, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center p-3">
                                        <form action="{{ route('user.review') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="room_id" value="{{ $resource->id }}">
                                            <input type="hidden" name="room_name" value="{{ $resource->name }}">
                                            <input type="hidden" name="option_type" value="Termasuk Sarapan">
                                            <input type="hidden" name="price" value="{{ $resource->price_per_hour + 75000 }}">
                                            <button type="submit" class="btn btn-sm btn-choose text-white px-3 fw-bold" style="background-color: #df9e45;">Pilih</button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-4 border p-5 text-center shadow-sm">
            <i class="fa-solid fa-bed text-muted mb-3" style="font-size: 4rem;"></i>
            <h4 class="fw-bold text-dark">Kamar Tidak Tersedia</h4>
            <p class="text-muted mb-0">Maaf, tidak ada tipe kamar yang cocok dengan parameter pencarian Anda.</p>
        </div>
        @endforelse

    </div>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/pilih-kamar.css') }}?v={{ time() }}">

@include('layouts.footer')
@endsection