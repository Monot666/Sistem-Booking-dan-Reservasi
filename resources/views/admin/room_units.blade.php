<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Unit Kamar - Roomly Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <style>
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
        }
        .page-subtitle {
            color: #64748b;
            font-size: 0.95rem;
        }
        .table-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .custom-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }
        .badge-occupied {
            background-color: #fef2f2;
            color: #dc2626;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1px solid #fca5a5;
        }
        .badge-vacant {
            background-color: #f0fdf4;
            color: #16a34a;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1px solid #86efac;
        }
        .filter-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
    </style>
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
            
            <li class="nav-logout">
                <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        <div class="mb-4">
            <h1 class="page-title">Manajemen Unit Kamar</h1>
            <p class="page-subtitle mb-0">Pantau ketersediaan fisik kamar secara dinamis berdasarkan tanggal.</p>
        </div>

        <div class="filter-container d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1 fw-bold text-dark">Filter Ketersediaan</h5>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Pilih tanggal untuk melihat kamar mana yang terisi atau kosong.</p>
            </div>
            <form action="{{ route('admin.room_units') }}" method="GET" class="d-flex align-items-center gap-2">
                <input type="date" name="date" class="form-control" value="{{ $date }}" required>
                <button type="submit" class="btn btn-warning fw-bold px-4" style="border-radius: 8px;">Cek Status</button>
            </form>
        </div>

        <div class="table-container">
            <h5 class="fw-bold mb-4">Status Kamar pada <span class="text-primary">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</span></h5>
            
            <div class="table-responsive">
                <table class="table custom-table text-center align-middle">
                    <thead>
                        <tr>
                            <th>Nomor Kamar</th>
                            <th>Tipe Kamar</th>
                            <th>Status pada {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roomUnits as $unit)
                        <tr>
                            <td class="fw-bold" style="font-size: 1.1rem; color: #1e293b;">{{ $unit->room_number }}</td>
                            <td>{{ $unit->room->name ?? 'Unknown Type' }}</td>
                            <td>
                                @if($unit->is_booked)
                                    <span class="badge-occupied" data-bs-toggle="tooltip" title="{{ $unit->active_booking ? $unit->active_booking->nama_pemesan : '' }}">
                                        <i class="fas fa-user-lock me-1"></i> Terisi
                                    </span>
                                @else
                                    <span class="badge-vacant"><i class="fas fa-check-circle me-1"></i> Kosong</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary fw-bold" data-bs-toggle="modal" data-bs-target="#scheduleModal{{ $unit->id }}">
                                    <i class="fas fa-calendar-alt me-1"></i> Detail Jadwal
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Modal for Schedule -->
                        <div class="modal fade" id="scheduleModal{{ $unit->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 16px; border: none;">
                                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                                        <h4 class="modal-title fw-bold">Jadwal Kamar {{ $unit->room_number }}</h4>
                                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4 text-start">
                                        <p class="text-muted mb-4">Daftar keseluruhan jadwal pemesanan untuk unit kamar ini.</p>
                                        
                                        @if($unit->bookings->count() > 0)
                                            <ul class="list-group list-group-flush">
                                            @foreach($unit->bookings as $booking)
                                                <li class="list-group-item px-0 py-3 border-bottom">
                                                    <div class="d-flex align-items-start">
                                                        <div class="badge-occupied me-3 mt-1 text-center" style="padding: 6px 10px; border-radius: 8px; min-width: 70px;">
                                                            <i class="fas fa-lock d-block mb-1"></i> Terisi
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="fw-bold text-dark mb-1 d-flex justify-content-between align-items-center">
                                                                <span>{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y') }}</span>
                                                                @if($booking->status === \App\Enums\BookingStatus::Pending)
                                                                    <span class="badge bg-warning text-dark border border-warning-subtle" style="font-size: 0.75rem;">Belum Lunas (Pending)</span>
                                                                @elseif($booking->status === \App\Enums\BookingStatus::Confirmed)
                                                                    <span class="badge bg-success border border-success-subtle" style="font-size: 0.75rem;">Lunas</span>
                                                                @else
                                                                    <span class="badge bg-secondary border border-secondary-subtle" style="font-size: 0.75rem;">{{ ucfirst($booking->status->value) }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-muted" style="font-size: 0.85rem;"><i class="fas fa-user me-1"></i> {{ $booking->nama_pemesan }}</div>
                                                            <div class="text-primary mt-1" style="font-size: 0.8rem;"><i class="fas fa-hashtag me-1"></i> Ref: #{{ $booking->id }}</div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                            </ul>
                                        @else
                                            <div class="text-center py-5">
                                                <i class="fas fa-calendar-check text-success mb-3" style="font-size: 3rem;"></i>
                                                <h5 class="fw-bold text-dark">Kamar Tersedia</h5>
                                                <p class="text-muted mb-0">Belum ada jadwal pesanan di masa depan untuk kamar ini.</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer border-0 pb-4 px-4">
                                        <button type="button" class="btn btn-light fw-bold w-100" data-bs-dismiss="modal" style="border-radius: 8px; border: 1px solid #e2e8f0;">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data unit kamar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
</body>
</html>
