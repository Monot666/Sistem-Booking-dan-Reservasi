<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Tamu - Roomly Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/guests.css') }}">
</head>
<body>

@php
// $guests passed from controller
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
        
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h1 class="page-title">Guest Management</h1>
                <p class="page-subtitle mb-0">Manage guest information and track loyalty</p>
            </div>
            <div class="total-guest-badge">
                <i class="fas fa-user-friends me-2"></i> Total: <b>{{ count($guests) }} Tamu</b>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 border-e2e8f0 px-3"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" id="guestSearch" class="form-control guest-search-input border-start-0 ps-0" placeholder="Search by name, email, or phone">
                </div>
            </div>
        </div>

        <div class="row g-4" id="guestsGrid">
            @foreach($guests as $g)
            @php
                // Hitung inisial nama
                $initial = collect(explode(' ', $g->name))->map(fn($n) => substr($n, 0, 1))->take(2)->join('');
            @endphp
            <div class="col-md-6 col-lg-3 guest-item">
                <div class="guest-card">
                    
                    <div class="d-flex align-items-center">
                        <div class="guest-avatar">{{ strtoupper($initial) }}</div>
                        <div class="ms-3">
                            <h6 class="guest-name">{{ $g->name }}</h6>
                        </div>
                    </div>

                    <div class="guest-contact">
                        <div class="guest-email"><i class="far fa-envelope"></i> <span>{{ $g->email }}</span></div>
                        <div class="guest-phone"><i class="fas fa-phone-alt"></i> <span>{{ $g->phone ?? '-' }}</span></div>
                    </div>

                    <div class="guest-details">
                        <div class="detail-row">
                            <span class="label">City of residence</span>
                            <span class="val">{{ $g->city ?? '-' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Total bookings</span>
                            <span class="val">{{ $g->bookings_count }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Last booking</span>
                            <span class="val">{{ $g->bookings_max_start_time ? \Carbon\Carbon::parse($g->bookings_max_start_time)->format('d-m-Y') : '-' }}</span>
                        </div>
                    </div>

                    @php
                        $wa_number = preg_replace('/^0/', '62', $g->phone ?? '0');
                        $pesan = "Hallo, kami dari Roomly";
                    @endphp
                    
                    <a href="https://wa.me/{{ $wa_number }}?text={{ rawurlencode($pesan) }}" class="btn-send-msg w-100" target="_blank">
                        Send Message
                    </a>

                </div>
            </div>
            @endforeach
        </div>

    </main>
</div>

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
<script src="{{ asset('assets/js/admin/guests.js') }}"></script>
</body>
</html>