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
// DUMMY DATA TAMU BERVARIASI
$guests = [
    ['id' => 1, 'initial' => 'DS', 'name' => 'Dimas Sudarmono', 'email' => 'monotxploit@gmail.com', 'phone' => '087759315863', 'city' => 'Solo', 'total_bookings' => 5, 'last_booking' => '13-03-2026'],
    ['id' => 2, 'initial' => 'BS', 'name' => 'Bayu Skak', 'email' => 'bayu.yowisben@gmail.com', 'phone' => '081234567890', 'city' => 'Malang', 'total_bookings' => 12, 'last_booking' => '20-04-2026'],
    ['id' => 3, 'initial' => 'BP', 'name' => 'Baskara Putra', 'email' => 'baskara.hindia@yahoo.com', 'phone' => '085678901234', 'city' => 'Jakarta', 'total_bookings' => 3, 'last_booking' => '05-05-2026'],
    ['id' => 4, 'initial' => 'AW', 'name' => 'Andi Wijaya', 'email' => 'andi.wijaya@outlook.com', 'phone' => '081122334455', 'city' => 'Surabaya', 'total_bookings' => 1, 'last_booking' => '10-01-2026'],
    ['id' => 5, 'initial' => 'SN', 'name' => 'Siti Nurhaliza', 'email' => 'siti.nur@gmail.com', 'phone' => '089988776655', 'city' => 'Bandung', 'total_bookings' => 7, 'last_booking' => '25-12-2025'],
    ['id' => 6, 'initial' => 'RO', 'name' => 'Reza Oktovian', 'email' => 'reza.arap@gmail.com', 'phone' => '082233445566', 'city' => 'Jakarta', 'total_bookings' => 2, 'last_booking' => '14-02-2026'],
    ['id' => 7, 'initial' => 'MA', 'name' => 'Maudy Ayunda', 'email' => 'maudy.ayunda@gmail.com', 'phone' => '087711223344', 'city' => 'Yogyakarta', 'total_bookings' => 4, 'last_booking' => '28-03-2026'],
    ['id' => 8, 'initial' => 'RD', 'name' => 'Raditya Dika', 'email' => 'raditya.dika@gmail.com', 'phone' => '081344556677', 'city' => 'Jakarta', 'total_bookings' => 8, 'last_booking' => '15-04-2026'],
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
            <div class="col-md-6 col-lg-3 guest-item">
                <div class="guest-card">
                    
                    <div class="d-flex align-items-center">
                        <div class="guest-avatar">{{ $g['initial'] }}</div>
                        <div class="ms-3">
                            <h6 class="guest-name">{{ $g['name'] }}</h6>
                        </div>
                    </div>

                    <div class="guest-contact">
                        <div class="guest-email"><i class="far fa-envelope"></i> <span>{{ $g['email'] }}</span></div>
                        <div class="guest-phone"><i class="fas fa-phone-alt"></i> <span>{{ $g['phone'] }}</span></div>
                    </div>

                    <div class="guest-details">
                        <div class="detail-row">
                            <span class="label">City of residence</span>
                            <span class="val">{{ $g['city'] }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Total bookings</span>
                            <span class="val">{{ $g['total_bookings'] }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Last booking</span>
                            <span class="val">{{ $g['last_booking'] }}</span>
                        </div>
                    </div>

                    @php
                        $wa_number = preg_replace('/^0/', '62', $g['phone']);
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