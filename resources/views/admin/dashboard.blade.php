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
            <li class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                <a href="{{ route('admin.bookings') }}"><i class="fas fa-calendar-alt"></i> Pesanan</a>
            </li>
            <li><a href="#"><i class="fas fa-users"></i> Tamu</a></li>
            <li><a href="#"><i class="fas fa-wallet"></i> Keuangan</a></li>
            <li class="nav-logout"><a href="#"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
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
                    
                    <div class="booking-item">
                        <div class="booking-avatar">DS</div>
                        <div class="booking-info">
                            <p class="booking-name">Dimas Sudarmono</p>
                            <p class="booking-room">Superior Double</p>
                        </div>
                        <div class="booking-date">12-03-2026</div>
                        <span class="badge-confirmed">Dikonfirmasi</span>
                    </div>

                    <div class="booking-item">
                        <div class="booking-avatar">DS</div>
                        <div class="booking-info">
                            <p class="booking-name">Dimas Sudarmono</p>
                            <p class="booking-room">Superior Double</p>
                        </div>
                        <div class="booking-date">12-03-2026</div>
                        <span class="badge-confirmed">Dikonfirmasi</span>
                    </div>

                    <div class="booking-item">
                        <div class="booking-avatar" style="background-color: #f1f3f5;">DS</div>
                        <div class="booking-info">
                            <p class="booking-name">Dimas Sudarmono</p>
                            <p class="booking-room">Superior Double</p>
                        </div>
                        <div class="booking-date">12-03-2026</div>
                        <span class="badge-pending">Menunggu</span>
                    </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/admin/dashboard.js') }}"></script>
</body>
</html>