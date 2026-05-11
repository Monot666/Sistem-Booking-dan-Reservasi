@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar_profile')
        </div>

        <div class="col-md-9">
            <div class="order-detail-header mb-4">
                <a href="{{ route('profile.orders') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-chevron-left"></i> Back to Orders
                </a>
            </div>

            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Booking Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Booking ID</h6>
                            <p class="fw-bold">#{{ $booking->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status</h6>
                            <p>
                                @if($booking->status === 'pending')
                                    <span class="badge bg-warning">PENDING</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="badge bg-success">CONFIRMED</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge bg-danger">CANCELLED</span>
                                @else
                                    <span class="badge bg-secondary">{{ strtoupper($booking->status) }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Room Name</h6>
                            <p class="fw-bold">{{ $booking->resource->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Room Type</h6>
                            <p class="fw-bold">{{ $booking->resource->type }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Check-in Date & Time</h6>
                            <p class="fw-bold">
                                {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Check-out Date & Time</h6>
                            <p class="fw-bold">
                                {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Duration</h6>
                            <p class="fw-bold">
                                {{ $booking->start_time->diffInHours($booking->end_time) }} hours
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Guest Name</h6>
                            <p class="fw-bold">{{ $booking->user->name }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Total Price</h6>
                            <p class="fw-bold fs-5" style="color: #d4a574;">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Payment Status</h6>
                            <p>
                                @if($booking->payments->isEmpty())
                                    <span class="badge bg-danger">NOT PAID</span>
                                @else
                                    @php
                                        $totalPaid = $booking->payments->sum('amount');
                                    @endphp
                                    @if($totalPaid >= $booking->total_price)
                                        <span class="badge bg-success">PAID</span>
                                    @else
                                        <span class="badge bg-warning">PARTIAL</span>
                                    @endif
                                @endif
                            </p>
                        </div>
                    </div>

                    @if(!$booking->payments->isEmpty())
                        <hr>
                        <h6 class="mb-3">Payment History</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->payments as $payment)
                                        <tr>
                                            <td>{{ $payment->created_at->format('d M Y, H:i') }}</td>
                                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                            <td>{{ ucfirst($payment->method) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Room Information</h5>
                </div>
                <div class="card-body">
                    <p>{{ $booking->resource->description }}</p>
                </div>
            </div>

            @if($booking->status === 'pending')
                <div class="mt-4">
                    <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        <i class="fas fa-credit-card"></i> Make Payment
                    </button>
                    <button class="btn btn-outline-danger">
                        <i class="fas fa-times"></i> Cancel Booking
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Make Payment</h5>
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
@endsection

@push('styles')
<style>
    .btn-gold {
        background: #d4a574;
        color: white;
        border: none;
    }

    .btn-gold:hover {
        background: #c89458;
        color: white;
    }

    .order-detail-header {
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 15px;
    }
</style>
@endpush
