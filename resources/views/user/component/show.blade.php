@extends('layouts.app')

@section('content')
<section class="resource-detail-page">
    <div class="container-fluid px-4 mb-4">
        <a href="{{ route('resources.index') }}" class="btn btn-back">
            &lt;
        </a>
    </div>

    <div class="resource-detail-container">
        <div class="row g-4">
            <!-- Image Gallery -->
            <div class="col-lg-6">
                <div class="resource-gallery">
                    <div class="main-image">
                        @if($resource->image)
                            <img id="main-image" src="{{ $resource->image }}" alt="{{ $resource->name }}">
                        @else
                            <img id="main-image" src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Room">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="col-lg-6">
                <div class="resource-details">
                    <h1>{{ $resource->name }}</h1>
                    <p class="resource-type">{{ $resource->type }}</p>

                    <div class="rating-section mb-4">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="rating-text">4.5 (120 reviews)</span>
                    </div>

                    <div class="price-section">
                        <span class="price">Rp {{ number_format($resource->price_per_hour, 0, ',', '.') }}</span>
                        <span class="period">/hour</span>
                    </div>

                    <div class="description-section mt-4">
                        <h3>Description</h3>
                        <p>{{ $resource->description }}</p>
                    </div>

                    <div class="facilities-section mt-4">
                        <h3>Facilities & Amenities</h3>
                        <div class="facilities-list">
                            <div class="facility">
                                <i class="fas fa-wifi"></i>
                                <span>Free Wi-Fi</span>
                            </div>
                            <div class="facility">
                                <i class="fas fa-snowflake"></i>
                                <span>Air Conditioning</span>
                            </div>
                            <div class="facility">
                                <i class="fas fa-shower"></i>
                                <span>Private Bathroom</span>
                            </div>
                            <div class="facility">
                                <i class="fas fa-tv"></i>
                                <span>Flat-screen TV</span>
                            </div>
                            <div class="facility">
                                <i class="fas fa-bath"></i>
                                <span>Bath Tub</span>
                            </div>
                            <div class="facility">
                                <i class="fas fa-bed"></i>
                                <span>{{ $resource->capacity }} Bed(s)</span>
                            </div>
                        </div>
                    </div>

                    <div class="booking-section mt-5">
                        <div class="alert alert-info">
                            Booking is disabled here. Please use the search results to choose an available room.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .resource-detail-page {
        padding: 40px 0;
        background: #f8f9fa;
        min-height: 100vh;
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

    .resource-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    }

    .resource-gallery {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .main-image {
        width: 100%;
        height: 400px;
        border-radius: 12px;
        overflow: hidden;
        background: #f0f0f0;
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .resource-details h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 8px;
        color: #222;
    }

    .resource-type {
        color: #999;
        font-size: 0.95rem;
        margin: 0 0 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rating-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stars {
        color: #d4a574;
        font-size: 1.1rem;
    }

    .rating-text {
        color: #666;
        font-size: 0.9rem;
    }

    .price-section {
        display: flex;
        align-items: baseline;
        gap: 5px;
        padding: 15px;
        background: #f0f0f0;
        border-radius: 8px;
    }

    .price {
        font-size: 2rem;
        font-weight: 700;
        color: #d4a574;
    }

    .period {
        color: #999;
        font-size: 0.95rem;
    }

    .description-section h3,
    .facilities-section h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #222;
    }

    .description-section p {
        color: #666;
        line-height: 1.6;
    }

    .facilities-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .facility {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .facility i {
        color: #d4a574;
        font-size: 1.2rem;
        width: 24px;
    }

    .facility span {
        color: #666;
        font-size: 0.9rem;
    }

    .btn-lg {
        padding: 12px 24px;
        font-size: 1.1rem;
    }

    .btn-gold {
        background: #d4a574;
        color: white;
        border: none;
    }

    .btn-gold:hover {
        background: #c89458;
        color: white;
    }

    @media (max-width: 768px) {
        .resource-detail-container {
            padding: 20px;
        }

        .resource-details h1 {
            font-size: 1.5rem;
        }

        .facilities-list {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush


