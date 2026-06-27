<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Admin Roomly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
</head>
<body>
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
            <li class="{{ request()->routeIs('admin.finance') ? 'active' : '' }}">
                <a href="{{ route('admin.finance') }}"><i class="fas fa-wallet"></i> Keuangan</a>
            </li>
            <li class="nav-logout" style="margin-top: auto;">
                <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" style="display: block;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <h1 class="page-title">Dasbor</h1>
        <p class="page-subtitle">Selamat datang kembali! Berikut adalah ringkasan hotel Anda.</p>
        
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="custom-card">
                    <div class="card-header-layout">
                        <span class="card-title-text">Total Pendapatan</span>
                        <i class="fas fa-dollar-sign card-icon"></i>
                    </div>
                    <div class="stat-value" style="font-size: 1.4rem;">Rp 1.005.000.000</div>
                    <div class="trend-up"><i class="fas fa-arrow-trend-up"></i> +12.5% dari bulan lalu</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom-card">
                    <div class="card-header-layout">
                        <span class="card-title-text">Total Pesanan</span>
                        <i class="far fa-calendar-check card-icon"></i>
                    </div>
                    <div class="stat-value">189</div>
                    <div class="trend-up"><i class="fas fa-arrow-trend-up"></i> +8.2% dari bulan lalu</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom-card">
                    <div class="card-header-layout">
                        <span class="card-title-text">Tingkat Hunian</span>
                        <i class="fas fa-bed card-icon"></i>
                    </div>
                    <div class="stat-value">85%</div>
                    <div class="trend-down"><i class="fas fa-arrow-trend-down"></i> -2.1% dari bulan lalu</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom-card">
                    <div class="card-header-layout">
                        <span class="card-title-text">Total Tamu</span>
                        <i class="fas fa-user-friends card-icon"></i>
                    </div>
                    <div class="stat-value">342</div>
                    <div class="trend-up"><i class="fas fa-arrow-trend-up"></i> +15.3% dari bulan lalu</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="custom-card">
                    <h5 class="section-title">Ringkasan Pendapatan</h5>
                    <div style="position: relative; height: 250px; width: 100%;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="custom-card">
                    <h5 class="section-title">Tren Pemesanan</h5>
                    <div style="position: relative; height: 250px; width: 100%;">
                        <canvas id="bookingTrend"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-8">
                <div class="custom-card">
                    <h5 class="section-title mb-3">Pesanan Terbaru</h5>
                    
                    @forelse ($recentBookings as $booking)
                        <div class="booking-item">
                            @php
                                $inisial = collect(explode(' ', $booking->user->name))->map(function($segment) {
                                    return strtoupper(substr($segment, 0, 1));
                                })->take(2)->join('');
                                
                                $statusNilai = is_object($booking->status) ? $booking->status->value : $booking->status;
                                $statusCek = strtolower($statusNilai);
                            @endphp
                            
                            <div class="booking-avatar" {{ $statusCek == 'pending' ? 'style="background-color: #f1f3f5;"' : '' }}>
                                {{ $inisial }}
                            </div>
                            
                            <div class="booking-info">
                                <p class="booking-name">{{ $booking->user->name }}</p>
                                <p class="booking-room">{{ $booking->room->name ?? 'Tipe Kamar' }} (ID: #{{ $booking->id }})</p>
                            </div>
                            
                            <div class="booking-date">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</div>
                            
                            @if($statusCek == 'success' || $statusCek == 'settlement' || $statusCek == 'dikonfirmasi' || $statusCek == 'paid' || $statusCek == 'confirmed')
                                <span class="badge-confirmed">Dikonfirmasi</span>
                            @elseif($statusCek == 'selesai' || $statusCek == 'completed' || $statusCek == 'checkout')
                                <span style="background-color: #e0f2fe; color: #0369a1; padding: 4px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">Selesai</span>
                            @elseif($statusCek == 'refund' || $statusCek == 'refunded' || $statusCek == 'dikembalikan')
                                <span style="background-color: #fee2e2; color: #b91c1c; padding: 4px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600;">Refund</span>
                            @else
                                <span class="badge-pending">Menunggu</span>
                            @endif
                        </div>
                    @empty
                        <div class="text-center p-4 text-muted">
                            Belum ada pesanan terbaru.
                        </div>
                    @endforelse
                </div>
            </div>
                
            <div class="col-md-4">
                <div class="custom-card">
                    <h5 class="section-title text-center">Hunian Kamar</h5>
                    <div style="position: relative; height: 200px; width: 100%; display: flex; justify-content: center;">
                        <canvas id="occupancyChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="occ-row"><span class="occ-label">Total Kamar</span><span class="occ-val">200</span></div>
                        <div class="occ-row"><span class="occ-label">Terisi</span><span class="occ-val">150</span></div>
                        <div class="occ-row"><span class="occ-label">Tersedia</span><span class="occ-val">50</span></div>
                    </div>
                </div>
            </div>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/admin/dashboard.js') }}"></script>
</body>
</html>