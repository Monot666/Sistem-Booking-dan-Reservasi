<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Pesanan - Roomly Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/bookings.css') }}">
</head>
<body>

@php
// $bookings passed from controller
@endphp

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="logo-area">
            <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="Logo">
            <div class="logo-text">
                <h4>Roomly Admin</h4>
                <small>Portal Manajemen</small>
            </div>
        </div>
        <ul class="nav-links">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-th-large"></i> Dasbor</a>
            </li>
            <li class="{{ request()->routeIs('admin.kamar') ? 'active' : '' }}">
                <a href="{{ route('admin.kamar') }}"><i class="fas fa-bed"></i> Kamar</a>
            </li>
            <li class="{{ request()->routeIs('admin.room_units') ? 'active' : '' }}">
                <a href="{{ route('admin.room_units') }}"><i class="fas fa-door-open"></i> Unit Kamar</a>
            </li>
            <li class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                <a href="{{ route('admin.bookings') }}"><i class="fas fa-calendar-alt"></i> Pesanan</a>
            </li>
            <li class="{{ request()->routeIs('admin.guests') ? 'active' : '' }}">
                <a href="{{ route('admin.guests') }}"><i class="fas fa-users"></i> Tamu</a>
            </li>
            <li><a href="{{ route('admin.finance') }}"><i class="fas fa-wallet"></i> Keuangan</a></li>
            
            <li class="nav-logout">
                <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        
        <div class="mb-4">
            <h1 class="page-title">Bookings Management</h1>
            <p class="page-subtitle mb-0">View and manage all hotel bookings</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="booking-stat-card">
                    <div class="booking-stat-title">Total Bookings <i class="fas fa-bed"></i></div>
                    <div class="booking-stat-value text-dark-value">{{ count($bookings) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="booking-stat-card">
                    <div class="booking-stat-title">Confirmed <i class="fas fa-check-double"></i></div>
                    <div class="booking-stat-value">{{ $bookings->where('status', \App\Enums\BookingStatus::Confirmed)->count() }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="booking-stat-card">
                    <div class="booking-stat-title">Total Revenue <i class="fas fa-dollar-sign"></i></div>
                    <div class="booking-stat-value">Rp.{{ number_format($bookings->whereIn('status', [\App\Enums\BookingStatus::Confirmed])->sum('total_price'), 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 border-e2e8f0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="bookingSearch" class="form-control search-input border-start-0 ps-0" placeholder="Search by booking ref, guest name...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select filter-select">
                    <option value="all">All Status</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table custom-table text-center align-middle">
                    <thead>
                        <tr>
                            <th>Booking Ref</th>
                            <th>Guest Name</th>
                            <th>Room</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Guest</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $b)
                        <tr class="booking-row">
                            <td class="fw-bold text-dark booking-ref">#{{ $b->id }}</td>
                            <td class="guest-name">{{ $b->nama_pemesan }}</td>
                            <td>{{ $b->room_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->start_time)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($b->end_time)->format('d-m-Y') }}</td>
                            <td>{{ $b->guest_count }}</td>
                            <td>Rp.{{ number_format($b->total_price, 0, ',', '.') }}</td>
                            <td class="booking-status" data-status="{{ strtolower($b->status->value ?? $b->status) }}">
                                @if($b->status === \App\Enums\BookingStatus::Confirmed) <span class="status-badge badge-confirmed">Confirmed</span>
                                @elseif($b->status === \App\Enums\BookingStatus::Cancelled) <span class="status-badge badge-cancelled">Cancelled</span>
                                @else <span class="status-badge badge-pending bg-warning text-dark px-2 rounded">Pending</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn-action" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $b->id }}">
                                    <i class="far fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

@foreach($bookings as $b)
<div class="modal fade" id="bookingModal{{ $b->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal p-2">
            
            <div class="d-flex justify-content-between align-items-center p-3 pb-0">
                <h4 class="fw-bold mb-0">Booking Details</h4>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="modal-header-black">
                    <div>
                        <small>Booking ID</small>
                        <h3>#{{ $b->id }}</h3>
                    </div>
                    <div>
                        @if($b->status === \App\Enums\BookingStatus::Confirmed) <span class="status-badge badge-confirmed">Confirmed</span>
                        @elseif($b->status === \App\Enums\BookingStatus::Cancelled) <span class="status-badge badge-cancelled">Cancelled</span>
                        @else <span class="status-badge badge-pending bg-warning text-dark px-2 rounded">Pending</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="detail-label">Guest Name</div>
                        <div class="detail-value">{{ $b->nama_pemesan }}</div>
                    </div>
                    <div class="col-6">
                        <div class="detail-label">Hotel & Room Number</div>
                        <div class="detail-value">Roomly ({{ $b->room_name }})</div>
                    </div>
                    
                    <div class="col-6">
                        <div class="detail-label">Check-In Date</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($b->start_time)->format('d-m-Y') }}</div>
                    </div>
                    <div class="col-6">
                        <div class="detail-label">Check-Out Date</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($b->end_time)->format('d-m-Y') }}</div>
                    </div>
                    
                    <div class="col-6">
                        <div class="detail-label">Guest</div>
                        <div class="detail-value">{{ $b->guest_count }} Pax</div>
                    </div>
                    <div class="col-6">
                        <div class="detail-label">Total Amount</div>
                        <div class="detail-value">Rp.{{ number_format($b->total_price, 0, ',', '.') }}</div>
                    </div>

                    <div class="col-12">
                        <div class="detail-label">Permintaan Khusus</div>
                        <div class="detail-value mb-0">{{ $b->permintaan_khusus ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4" style="border-radius: 16px; border: none;">
            <div class="mb-3">
                <i class="fas fa-sign-out-alt text-danger" style="font-size: 3.5rem;"></i>
            </div>
            <h4 class="fw-bold mb-2" style="color: #1e293b;">Konfirmasi Keluar</h4>
            <p class="text-muted mb-4">Apakah Anda yakin ingin keluar dari portal Admin Roomly? Sesi Anda akan diakhiri.</p>
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 8px; border: 1px solid #e2e8f0; color: #475569;">Batal</button>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 8px;">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/admin/bookings.js') }}"></script>
</body>
</html>