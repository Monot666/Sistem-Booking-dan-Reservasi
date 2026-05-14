@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kartu.css') }}">
    <style>
        .nav-order {
            border-bottom: 2px solid #e0e0e0;
            margin-bottom: 30px;
        }

        .nav-order .nav-link {
            color: #666;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
        }

        .nav-order .nav-link.active {
            color: #d4a574;
            border-bottom-color: #d4a574;
        }

        .order-card {
            background: white;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .hotel-img {
            width: 180px;
            height: 180px;
            object-fit: cover;
        }

        .status-paid {
            background: #d4f1d4;
            color: #2d5a2d;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-block;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-block;
        }

        .date-box {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }

        .price-tag {
            font-size: 1.3rem;
            font-weight: 700;
            color: #d4a574;
        }

        .btn-cancel {
            background: white;
            color: #666;
            border: 1px solid #ddd;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
        }

        .btn-maps, .btn-pay {
            background: #d4a574;
            color: white;
            border: none;
        }

        .btn-maps:hover, .btn-pay:hover {
            background: #c89458;
        }

        .order-details p {
            margin: 5px 0;
            font-size: 0.9rem;
            color: #666;
        }

        .empty-message {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-message i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ddd;
        }
    </style>
@endpush

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar_profile')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>My Bookings</h3>
                <a href="{{ route('resources.index') }}" class="btn btn-gold">
                    <i class="fas fa-plus"></i> New Booking
                </a>
            </div>

            @if($bookings->isEmpty())
                <div class="order-card">
                    <div class="empty-message">
                        <i class="fas fa-calendar-alt"></i>
                        <h5>No Bookings Yet</h5>
                        <p>Start your journey by booking a room today!</p>
                        <a href="{{ route('resources.index') }}" class="btn btn-gold mt-3">Browse Rooms</a>
                    </div>
                </div>
            @else
                @foreach($bookings as $booking)
                    <div class="order-card d-flex">
                        <img src="@if($booking->resource->image){{ $booking->resource->image }}@else https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60 @endif" class="hotel-img" alt="{{ $booking->resource->name }}">
                        
                        <div class="p-3 flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-0">{{ $booking->resource->name }}</h5>
                                    <small class="text-muted">ID Pesanan: {{ $booking->id }}</small>
                                    <div class="mt-1">
                                        @if($booking->status === 'pending')
                                            <span class="status-pending">
                                                <i class="fas fa-clock"></i> PERLU DIBAYAR
                                            </span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="status-paid">
                                                <i class="fas fa-check-circle"></i> DIKONFIRMASI
                                            </span>
                                        @else
                                            <span class="status-pending">
                                                <i class="fas fa-times-circle"></i> DIBATALKAN
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex gap-3 text-center">
                                    <div class="date-box">
                                        <small class="text-muted d-block">CHECK-IN</small>
                                        <span class="fw-bold h4">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</span>
                                        <small>{{ $booking->start_time->format('M Y') }}<br>{{ $booking->start_time->format('D') }}</small>
                                    </div>
                                    <div class="date-box">
                                        <small class="text-muted d-block">CHECK-OUT</small>
                                        <span class="fw-bold h4">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</span>
                                        <small>{{ $booking->end_time->format('M Y') }}<br>{{ $booking->end_time->format('D') }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="order-details mt-2">
                                <p><i class="fas fa-door-open me-1"></i> {{ $booking->resource->type }}</p>
                                <p><i class="fas fa-clock me-1"></i> {{ $booking->start_time->diffInHours($booking->end_time) }} hours</p>
                                <p><i class="fas fa-user me-1"></i> Guest: {{ $booking->user->name }}</p>
                                <p><i class="fas fa-wifi me-1"></i> Free Wi-Fi</p>
                            </div>

                            <div class="d-flex justify-content-between align-items-end mt-2">
                                <div class="price-tag">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-maps px-3 py-1">
                                        View Details
                                    </a>
                                    @if($booking->status === 'pending')
                                        <button class="btn btn-pay px-4 py-1" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $booking->id }}">
                                            Pay Now
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Modal for each booking -->
                    @if($booking->status === 'pending')
                        <div class="modal fade" id="paymentModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Make Payment - {{ $booking->resource->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('payments.store') ?? '#' }}">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="number" class="form-control" name="amount" value="{{ $booking->total_price }}" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Payment Method</label>
                                                <select class="form-select" name="method" required>
                                                    <option value="card">Credit Card</option>
                                                    <option value="bank_transfer">Bank Transfer</option>
                                                    <option value="ewallet">E-Wallet</option>
                                                </select>
                                            </div>

                                            <div class="alert alert-info">
                                                <strong>Total to Pay:</strong>
                                                <br>
                                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-gold">Proceed to Payment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .btn-gold {
        background: #d4a574;
        color: white;
    }
    
    .btn-gold:hover {
        background: #c89458;
        color: white;
    }
</style>
@endpush