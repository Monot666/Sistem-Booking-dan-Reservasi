@extends('layouts.app')

@section('content')
<section class="resources-page">
    <div class="resources-container">
        <div class="container-fluid px-4 mb-4">
            <a href="{{ route('booking') }}" class="btn btn-back" onclick="if(history.length > 1){ history.back(); return false; }">
                &lt;
            </a>
        </div>

        <div class="resources-header">
            <h1>Available Rooms</h1>
            <p>Choose your perfect room for your stay</p>
        </div>

        @if(request()->filled('checkin') && request()->filled('checkout'))
            <div class="bg-white rounded-4 p-4 mb-4 shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <strong>Check-in</strong>
                        <div>{{ \Carbon\Carbon::parse(request('checkin'))->format('d M Y') }}</div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <strong>Check-out</strong>
                        <div>{{ \Carbon\Carbon::parse(request('checkout'))->format('d M Y') }}</div>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <strong>Guests</strong>
                        <div>{{ request('guests', 1) }}</div>
                    </div>
                    <div class="col-md-2 mb-3 mb-md-0">
                        <strong>Rooms</strong>
                        <div>{{ request('rooms', 1) }}</div>
                    </div>
                </div>
            </div>
        @endif

        <div class="resources-grid">
            @forelse($resources as $resource)
                @php
                    $defaultImages = [
                        'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=900&q=80',
                        'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=900&q=80',
                        'https://images.unsplash.com/photo-1494526585095-c41746248156?auto=format&fit=crop&w=900&q=80',
                    ];
                    $image = $resource->image ?: $defaultImages[$loop->index % count($defaultImages)];
                @endphp
                <div class="resource-card">
                    <div class="resource-image">
                        <img src="{{ $image }}" alt="{{ $resource->name }}">
                    </div>
                    <div class="resource-info">
                        <div class="resource-top">
                            <span class="resource-badge">{{ strtoupper($resource->type) }}</span>
                            <span class="resource-price-tag">Rp {{ number_format($resource->price_per_hour, 0, ',', '.') }} /hour</span>
                        </div>
                        <h3>{{ $resource->name }}</h3>
                        <p class="resource-description">{{ Str::limit($resource->description ?: 'A premium room with comfortable amenities and a stylish interior.', 110) }}</p>

                        <div class="resource-meta">
                            <span class="meta-item"><i class="fas fa-users"></i> {{ $resource->capacity }} Guests</span>
                            <span class="meta-item"><i class="fas fa-bed"></i> {{ $resource->capacity }} Bed{{ $resource->capacity > 1 ? 's' : '' }}</span>
                        </div>

                        <div class="resource-actions">
                            <a href="{{ route('resources.show', $resource->id) }}" class="btn btn-outline">View Details</a>
                            <a href="{{ route('resources.show', $resource->id) }}" class="btn btn-gold">Choose</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">No available rooms match your selected dates and filters.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .resources-page {
        padding: 40px 0;
        background: #f8f9fa;
        min-height: 100vh;
    }

    .resources-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .resources-header {
        text-align: left;
        margin-bottom: 40px;
    }

    .btn-back {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        border: 1px solid #d4af37;
        background: rgba(212, 175, 55, 0.16);
        color: #d4af37;
        font-size: 1.25rem;
        font-weight: 700;
        display: grid;
        place-items: center;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .btn-back:hover {
        background: rgba(212, 175, 55, 0.24);
        text-decoration: none;
    }

    .resources-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 10px;
    }

    .resources-header p {
        font-size: 1.1rem;
        color: #666;
    }

    .filters-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }

    .resources-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .resource-card {
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(212, 176, 114, 0.14);
    }

    .resource-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 32px 70px rgba(0, 0, 0, 0.12);
    }

    .resource-image {
        width: 100%;
        min-height: 220px;
        overflow: hidden;
        position: relative;
        background: #f3f1eb;
    }

    .resource-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .resource-card:hover .resource-image img {
        transform: scale(1.08);
    }

    .resource-info {
        padding: 26px;
    }

    .resource-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .resource-badge {
        background: #f9ecd5;
        color: #8f6f38;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .resource-price-tag {
        color: #a97d3b;
        font-size: 0.95rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .resource-info h3 {
        font-size: 1.45rem;
        font-weight: 800;
        margin: 0 0 10px;
        color: #1f1f1f;
    }

    .resource-type {
        display: inline-block;
        margin-bottom: 14px;
        color: #b79f6f;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .resource-description {
        color: #6f6f6f;
        font-size: 0.95rem;
        line-height: 1.75;
        margin-bottom: 20px;
        min-height: 72px;
    }

    .resource-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f9f1e1;
        border-radius: 999px;
        padding: 10px 14px;
        color: #7d6238;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .meta-item i {
        color: #c38f42;
    }

    .resource-actions {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 130px;
        padding: 12px 18px;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-outline {
        background: #ffffff;
        color: #a97d3b;
        border: 2px solid #f0d7a2;
    }

    .btn-outline:hover {
        background: #f8f0e3;
        color: #7d6238;
    }

    .btn-gold {
        background: #c38f42;
        color: #ffffff;
        border: none;
    }

    .btn-gold:hover {
        background: #a97833;
    }

    .alert-info {
        background: #fff6eb;
        border-color: #f3d7b7;
        color: #7d6238;
    }
</style>
@endpush


