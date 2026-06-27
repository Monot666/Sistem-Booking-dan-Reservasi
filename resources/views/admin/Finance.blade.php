<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Keuangan - Roomly Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/finance.css') }}">
</head>
<body>

@php
// Data is now passed directly from Admin\PaymentController
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
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="page-title">Financial Management</h1>
                <p class="page-subtitle mb-0">Track revenue, expenses, and financial performance</p>
            </div>
            <button class="btn-save-data" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="far fa-save me-2"></i> Save Data
            </button>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="finance-card bg-revenue">
                    <div class="finance-card-title">Total Revenue <i class="fas fa-arrow-trend-up"></i></div>
                    <div class="finance-card-value"><span class="currency-symbol">Rp</span>{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="finance-card-subtitle">+12% from last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="finance-card bg-expense">
                    <div class="finance-card-title">Total Expenses <i class="fas fa-arrow-trend-down"></i></div>
                    <div class="finance-card-value"><span class="currency-symbol">Rp</span>{{ number_format($totalExpense, 0, ',', '.') }}</div>
                    <div class="finance-card-subtitle">+5% from last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="finance-card bg-profit">
                    <div class="finance-card-title">Net Profit <i class="fas fa-money-bill-wave"></i></div>
                    <div class="finance-card-value"><span class="currency-symbol">Rp</span>{{ number_format($netProfit, 0, ',', '.') }}</div>
                    <div class="finance-card-subtitle">Profit Margin: +67.2%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="finance-card bg-transactions">
                    <div class="finance-card-title">Transactions <i class="far fa-calendar-alt"></i></div>
                    <div class="finance-card-value">{{ count($transactions) }}</div>
                    <div class="finance-card-subtitle">All Time</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="chart-title">Profit Trend</h5>
                    <div class="chart-wrapper">
                        <canvas id="profitLineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="chart-title">Monthly Performance</h5>
                    <div class="chart-wrapper">
                        <canvas id="performanceBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="finance-table-container">
            <div class="finance-table-header">
                <h5 class="fw-bold mb-0 text-dark">Recent Transactions</h5>
                <div class="d-flex gap-3">
                    <select id="catFilter" class="finance-filter-select">
                        <option value="all">All Categories</option>
                        <option value="revenue">Revenue</option>
                        <option value="expense">Expense</option>
                        <option value="refund">Refund</option>
                    </select>
                    <select id="timeFilter" class="finance-filter-select">
                        <option value="default">Berdasarkan Bulan</option>
                        <option value="newest">Terbaru ke Terlama</option>
                        <option value="oldest">Terlama ke Terbaru</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table custom-table text-center align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-start">Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Method</th>
                        </tr>
                    </thead>
                    <tbody id="transactionBody">
                        @foreach($transactions as $t)
                        <tr class="transaction-row" data-category="{{ strtolower($t->type->value ?? $t->type) }}">
                            <td class="tx-date">{{ \Carbon\Carbon::parse($t->date)->format('d-m-Y') }}</td>
                            <td class="text-start">{{ $t->description }}</td>
                            <td>
                                @if(($t->type->value ?? $t->type) == 'Revenue') <span class="badge-cat cat-revenue">Revenue</span>
                                @elseif(($t->type->value ?? $t->type) == 'Expense') <span class="badge-cat cat-expense">Expense</span>
                                @elseif(($t->type->value ?? $t->type) == 'Refund') <span class="badge-cat cat-refund">Refund</span>
                                @endif
                            </td>
                            <td style="color: {{ ($t->type->value ?? $t->type) == 'Expense' || ($t->type->value ?? $t->type) == 'Refund' ? '#ef4444' : '#16a34a' }}">
                                {{ ($t->type->value ?? $t->type) == 'Expense' || ($t->type->value ?? $t->type) == 'Refund' ? '-' : '+' }} Rp. {{ number_format($t->amount, 0, ',', '.') }}
                            </td>
                            <td>{{ $t->method }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal p-4 text-center">
            
            <div class="mb-3">
                <i class="fas fa-sign-out-alt text-danger" style="font-size: 3.5rem;"></i>
            </div>
            
            <h4 class="fw-bold mb-2">Konfirmasi Keluar</h4>
            <p class="text-muted mb-4">Apakah Anda yakin ingin keluar dari portal Admin Roomly? Sesi Anda akan diakhiri.</p>
            
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 8px; border: 1px solid #e2e8f0;">Batal</button>
                
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 8px;">Ya, Keluar</button>
                </form>
            </div>
            
        </div>
    </div>
</div>

<!-- Export Data Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="color: #1e293b;">Export Data Transaksi</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-4">Pilih rentang tanggal transaksi yang ingin Anda unduh dalam format Excel (.xlsx).</p>
                <form id="exportForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mulai Tanggal</label>
                        <input type="date" class="form-control" id="exportStartDate" name="start_date">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="exportEndDate" name="end_date">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="border-radius: 8px;">
                        <i class="fas fa-file-excel me-2"></i> Unduh File Excel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
<script>
    window.financeChartData = {
        labels: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
        revenue: {!! json_encode($chartRevenue ?? [0,0,0,0,0,0]) !!},
        expense: {!! json_encode($chartExpense ?? [0,0,0,0,0,0]) !!},
        profit: {!! json_encode($chartProfit ?? [0,0,0,0,0,0]) !!}
    };

    // Export Logic using SheetJS
    document.getElementById('exportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const startDate = document.getElementById('exportStartDate').value;
        const endDate = document.getElementById('exportEndDate').value;
        let url = "{{ route('admin.finance.export') }}?";
        if (startDate) url += "start_date=" + startDate + "&";
        if (endDate) url += "end_date=" + endDate;

        const btn = this.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
        btn.disabled = true;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if(data.length === 0) {
                    alert('Tidak ada transaksi pada rentang tanggal tersebut.');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    return;
                }

                const worksheet = XLSX.utils.json_to_sheet(data);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Transactions");

                let filename = "Laporan_Keuangan_Admin_Roomly";
                if (startDate && endDate) filename += "_" + startDate + "_to_" + endDate;
                else filename += "_" + new Date().toISOString().slice(0,10);
                filename += ".xlsx";

                XLSX.writeFile(workbook, filename);

                btn.innerHTML = originalText;
                btn.disabled = false;
                bootstrap.Modal.getInstance(document.getElementById('exportModal')).hide();
            })
            .catch(err => {
                console.error('Export error:', err);
                alert('Terjadi kesalahan saat mengekspor data.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    });
</script>
<script src="{{ asset('assets/js/admin/finance.js') }}"></script>
</body>
</html>