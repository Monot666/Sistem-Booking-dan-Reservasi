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
// DUMMY DATA (Status Pending dihapus)
$bookings = [
    ['id' => 1, 'ref' => 'BK001', 'guest' => 'Dimas Sudarmono', 'room' => '212', 'checkin' => '12-03-2026', 'checkout' => '13-03-2026', 'pax' => 2, 'amount' => 535000, 'status' => 'Confirmed'],
    ['id' => 2, 'ref' => 'BK002', 'guest' => 'Baskara Putra', 'room' => '104', 'checkin' => '14-03-2026', 'checkout' => '16-03-2026', 'pax' => 1, 'amount' => 890000, 'status' => 'Confirmed'],
    ['id' => 3, 'ref' => 'BK003', 'guest' => 'Nereus', 'room' => '305', 'checkin' => '10-03-2026', 'checkout' => '11-03-2026', 'pax' => 2, 'amount' => 600000, 'status' => 'Completed'],
    ['id' => 4, 'ref' => 'BK004', 'guest' => 'Praya', 'room' => '210', 'checkin' => '15-03-2026', 'checkout' => '15-03-2026', 'pax' => 1, 'amount' => 450000, 'status' => 'Cancelled'],
    ['id' => 5, 'ref' => 'BK005', 'guest' => 'Andi Wijaya', 'room' => '101', 'checkin' => '16-03-2026', 'checkout' => '18-03-2026', 'pax' => 2, 'amount' => 750000, 'status' => 'Confirmed'],
];
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
                    <div class="booking-stat-value">3</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="booking-stat-card">
                    <div class="booking-stat-title">Total Revenue <i class="fas fa-dollar-sign"></i></div>
                    <div class="booking-stat-value">$7,760</div>
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
                            <td class="fw-bold text-dark booking-ref">{{ $b['ref'] }}</td>
                            <td class="guest-name">{{ $b['guest'] }}</td>
                            <td>{{ $b['room'] }}</td>
                            <td>{{ $b['checkin'] }}</td>
                            <td>{{ $b['checkout'] }}</td>
                            <td>{{ $b['pax'] }}</td>
                            <td>Rp.{{ number_format($b['amount'], 0, ',', '.') }}</td>
                            <td class="booking-status" data-status="{{ strtolower($b['status']) }}">
                                @if($b['status'] == 'Confirmed') <span class="status-badge badge-confirmed">Confirmed</span>
                                @elseif($b['status'] == 'Completed') <span class="status-badge badge-completed">Completed</span>
                                @elseif($b['status'] == 'Cancelled') <span class="status-badge badge-cancelled">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn-action" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $b['id'] }}">
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
<div class="modal fade" id="bookingModal{{ $b['id'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal p-2">
            
            <div class="d-flex justify-content-between align-items-center p-3 pb-0">
                <h4 class="fw-bold mb-0">Booking Details</h4>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <div class="modal-header-black">
                    <div>
                        <small>Booking Reference</small>
                        <h3>{{ $b['ref'] }}</h3>
                    </div>
                    <div>
                        @if($b['status'] == 'Confirmed') <span class="status-badge badge-confirmed">Confirmed</span>
                        @elseif($b['status'] == 'Completed') <span class="status-badge badge-completed">Completed</span>
                        @elseif($b['status'] == 'Cancelled') <span class="status-badge badge-cancelled">Cancelled</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="detail-label">Guest Name</div>
                        <div class="detail-value">{{ $b['guest'] }}</div>
                    </div>
                    <div class="col-6">
                        <div class="detail-label">Hotel & Room Number</div>
                        <div class="detail-value">Aston Solo Hotel ({{ $b['room'] }})</div>
                    </div>
                    
                    <div class="col-6">
                        <div class="detail-label">Check-In Date</div>
                        <div class="detail-value">{{ $b['checkin'] }}</div>
                    </div>
                    <div class="col-6">
                        <div class="detail-label">Check-Out Date</div>
                        <div class="detail-value">{{ $b['checkout'] }}</div>
                    </div>
                    
                    <div class="col-6">
                        <div class="detail-label">Guest</div>
                        <div class="detail-value">{{ $b['pax'] }}</div>
                    </div>
                    <div class="col-6">
                        <div class="detail-label">Total Amount</div>
                        <div class="detail-value">Rp.{{ number_format($b['amount'], 0, ',', '.') }}</div>
                    </div>

                    <div class="col-12">
                        <div class="detail-label">Permintaan Khusus</div>
                        <div class="detail-value mb-0">Smoking area, 1 ranjang besar</div>
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