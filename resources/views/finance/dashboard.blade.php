<!DOCTYPE html>
<html lang="en">
<head>
    <title>Finance Dashboard - Roomly</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/finance/finance.css') }}">
</head>

<body>

@php
// $transactions, $totalRevenue, $totalExpense, $netProfit passed from controller
@endphp

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="logo-area">
            <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="Logo">
            <div class="logo-text">
                <h4>Roomly Finance</h4>
                <small>Management Portal</small>
            </div>
        </div>
        
        <ul class="nav-links" style="display: flex; flex-direction: column; gap: 5px;">
            <li class="active">
                <a href="#"><i class="fas fa-th-large"></i> Dashboard</a>
            </li>
            <li>
                <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" style="border: none; background: transparent;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content" style="background-color: #f4f7fe; min-height: 100vh;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold" style="color: #2b3674; font-size: 1.8rem;">Financial Management</h1>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Track revenue, expenses, and financial performance</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn-save-data" id="btnSaveData" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="far fa-save me-2"></i> Save Data
                </button>
                <button class="btn-add-tx" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                    <i class="fas fa-plus me-1"></i> Add Transaction
                </button>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card solid-green">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="stat-title">Total Revenue</span>
                        <i class="fas fa-arrow-trend-up"></i>
                    </div>
                    <div class="stat-amount">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="stat-desc">+12% from last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card solid-red">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="stat-title">Total Expenses</span>
                        <i class="fas fa-arrow-trend-down"></i>
                    </div>
                    <div class="stat-amount">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                    <div class="stat-desc">+5% from last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card solid-gold">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="stat-title">Net Profit</span>
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="stat-amount">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
                    <div class="stat-desc">Profit Margin: +67.2%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card solid-dark">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="stat-title">Transactions</span>
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div class="stat-amount">{{ $transactions->count() }}</div>
                    <div class="stat-desc">This month</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="bg-white p-4" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                    <h6 class="fw-bold mb-4" style="color: #1e293b;">Profit Trend</h6>
                    <div style="height: 250px; width: 100%;">
                        <canvas id="profitLineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white p-4" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                    <h6 class="fw-bold mb-4" style="color: #1e293b;">Monthly Performance</h6>
                    <div style="height: 250px; width: 100%;">
                        <canvas id="performanceBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-4" style="border-radius: 12px; border: 1px solid #e2e8f0;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0" style="color: #1e293b;">Recent Transactions</h6>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm shadow-none table-filter-select">
                        <option>All Categories</option>
                        <option>Revenue</option>
                        <option>Expense</option>
                    </select>
                    <select class="form-select form-select-sm shadow-none table-filter-select">
                        <option>All Time</option>
                        <option>This Month</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table modern-table align-middle text-center mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-start">Description</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Action</th> </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $t)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($t->date)->format('d-m-Y') }}</td>
                            <td class="text-start fw-medium" style="color: #334155;">{{ $t->description }}</td>
                            <td>
                                <span class="badge-cat {{ strtolower($t->type->value ?? $t->type) }}">{{ $t->type->value ?? $t->type }}</span>
                            </td>
                            <td class="fw-semibold" style="color: {{ ($t->type->value ?? $t->type) === 'Expense' || ($t->type->value ?? $t->type) === 'Refund' ? '#ef4444' : '#10b981' }}">
                                Rp. {{ number_format($t->amount, 0, ',', '.') }}
                            </td>
                            <td>{{ $t->method }}</td>
                            <td>
                                <span class="badge-status">{{ $t->status }}</span>
                            </td>
                            <td>
                                <button class="btn-action-detail" data-bs-toggle="modal" data-bs-target="#detailModal{{ $t->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if(empty($t->booking_id))
                                <button class="btn-action-detail ms-1 text-primary" data-bs-toggle="modal" data-bs-target="#editTransactionModal{{ $t->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action-detail ms-1 text-danger" data-bs-toggle="modal" data-bs-target="#deleteTransactionModal{{ $t->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Refund Requests Section -->
        <div class="glass-card mt-5">
            <h4 class="section-title mb-4">Refund Requests <span class="badge bg-warning text-dark ms-2">{{ count($refundRequests) }} Pending</span></h4>
            <div class="table-responsive">
                <table class="table custom-table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Date Requested</th>
                            <th>Guest Name</th>
                            <th>Reason</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($refundRequests as $req)
                        <tr>
                            <td class="fw-bold text-dark">#BK{{ str_pad($req->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $req->updated_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $req->user->name ?? $req->nama_pemesan }}</td>
                            <td class="text-start" style="max-width: 250px; white-space: normal; font-size: 0.9rem;">
                                <strong>Alasan:</strong> {{ $req->refund_reason }}<br>
                                <div class="mt-2" style="background-color: #f1f5f9; padding: 8px; border-radius: 6px;">
                                    <strong>Metode:</strong> {{ $req->refund_payment_method }}<br>
                                    <strong>No. Akun:</strong> {{ $req->refund_payment_account }}<br>
                                    <strong>A.N:</strong> {{ $req->refund_account_name }}
                                </div>
                            </td>
                            <td class="fw-semibold text-danger">
                                Rp. {{ number_format($req->total_price, 0, ',', '.') }}
                            </td>
                            <td>
                                <form action="{{ route('finance.refunds.confirm', $req->id) }}" method="POST" class="d-inline-block m-0" id="refund-form-{{ $req->id }}">
                                    @csrf
                                    <button type="button" class="btn btn-sm btn-success fw-bold px-3 py-2" style="border-radius: 6px;"
                                        onclick="showRefundModal({{ $req->id }})">
                                        <i class="fas fa-check-circle me-1"></i> Konfirmasi Refund
                                    </button>
                                </form>
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No pending refund requests.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

@foreach($transactions as $t)
<div class="modal fade" id="detailModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="color: #1e293b;">Transaction Details</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Transaction ID:</span>
                    <span class="fw-bold text-dark">#{{ $t->id }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Date:</span>
                    <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($t->date)->format('d-m-Y') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Description:</span>
                    <span class="fw-bold text-dark text-end">{{ $t->description }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Category:</span>
                    <span class="badge-cat {{ strtolower($t->type->value ?? $t->type) }}">{{ $t->type->value ?? $t->type }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Payment Method:</span>
                    <span class="fw-bold text-dark">{{ $t->method }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Status:</span>
                    <span class="badge-status">{{ $t->status }}</span>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <span class="text-muted fw-bold">Total Amount:</span>
                    <span class="fw-bold fs-5" style="color: {{ ($t->type->value ?? $t->type) === 'Expense' || ($t->type->value ?? $t->type) === 'Refund' ? '#ef4444' : '#10b981' }}">
                        Rp. {{ number_format($t->amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn w-100" data-bs-dismiss="modal" style="background-color: #f1f5f9; color: #475569; font-weight: 600; border-radius: 8px;">Close</button>
            </div>
        </div>
    </div>
</div>

@if(empty($t->booking_id))
<div class="modal fade" id="editTransactionModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; padding: 10px;">
            <div class="modal-header border-0 pb-0">
                <h4 class="modal-title fw-bold" style="color: #1e293b;">Edit Transaction</h4>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('finance.transactions.update', $t->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="custom-form-label">Date</label>
                        <input type="date" class="form-control custom-form-input" name="date" value="{{ \Carbon\Carbon::parse($t->date)->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="custom-form-label">Description</label>
                        <input type="text" class="form-control custom-form-input" name="description" value="{{ $t->description }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="custom-form-label">Category</label>
                        <select class="form-select custom-form-input" name="type" required>
                            <option value="Revenue" {{ ($t->type->value ?? $t->type) == 'Revenue' ? 'selected' : '' }}>Revenue</option>
                            <option value="Expense" {{ ($t->type->value ?? $t->type) == 'Expense' ? 'selected' : '' }}>Expense</option>
                            <option value="Refund" {{ ($t->type->value ?? $t->type) == 'Refund' ? 'selected' : '' }}>Refund</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="custom-form-label">Amount (Rp)</label>
                        <input type="number" class="form-control custom-form-input" name="amount" value="{{ $t->amount }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="custom-form-label">Payment Method</label>
                        <select class="form-select custom-form-input" name="method" required>
                            <option value="Virtual Account" {{ $t->method == 'Virtual Account' ? 'selected' : '' }}>Virtual Account</option>
                            <option value="Bank Transfer" {{ $t->method == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="Cash" {{ $t->method == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Credit Card" {{ $t->method == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                        </select>
                    </div>
                    <button type="submit" class="btn w-100 mt-2" style="background-color: #3b82f6; color: white; border-radius: 8px; font-weight: 600; padding: 12px;">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteTransactionModal{{ $t->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4 border-0 shadow-lg" style="border-radius: 16px;">
            <div class="mb-3"><i class="fas fa-trash text-danger" style="font-size: 3.5rem;"></i></div>
            <h4 class="fw-bold mb-2">Delete Transaction?</h4>
            <p class="text-muted mb-4">Are you sure you want to delete this transaction? This cannot be undone.</p>
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <form action="{{ route('finance.transactions.destroy', $t->id) }}" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 8px;">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endforeach

<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; padding: 10px;">
            <div class="modal-header border-0 pb-0">
                <h4 class="modal-title fw-bold" style="color: #1e293b;">Add New Transaction</h4>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('finance.transactions.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="custom-form-label">Date</label>
                        <input type="date" class="form-control custom-form-input" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label class="custom-form-label">Description</label>
                        <input type="text" class="form-control custom-form-input" name="description" placeholder="Room Booking" required>
                    </div>
                    <div class="mb-3">
                        <label class="custom-form-label">Category</label>
                        <select class="form-select custom-form-input" name="type" required>
                            <option value="" disabled selected hidden>Select Category</option>
                            <option value="Revenue">Revenue</option>
                            <option value="Expense">Expense</option>
                            <option value="Refund">Refund</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="custom-form-label">Amount (Rp)</label>
                        <input type="number" class="form-control custom-form-input" name="amount" placeholder="10000" required>
                    </div>
                    <div class="mb-4">
                        <label class="custom-form-label">Payment Method</label>
                        <select class="form-select custom-form-input" name="method" required>
                            <option value="" disabled selected hidden>Select Method</option>
                            <option value="Virtual Account">Virtual Account</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <button type="submit" class="btn w-100 mt-2" style="background-color: #df9e4c; color: white; border-radius: 8px; font-weight: 600; padding: 12px; transition: 0.2s;">Add Transaction</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4 border-0 shadow-lg" style="border-radius: 16px;">
            <div class="mb-3"><i class="fas fa-sign-out-alt text-danger" style="font-size: 3.5rem;"></i></div>
            <h4 class="fw-bold mb-2">Confirm Logout</h4>
            <p class="text-muted mb-4">Are you sure you want to log out from Roomly Finance?</p>
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 8px; border: 1px solid #e2e8f0;">Cancel</button>
                
                <form action="{{ url('/logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 8px;">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Refund Confirmation Modal -->
<div class="modal fade" id="refundConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4 border-0 shadow-lg" style="border-radius: 16px;">
            <div class="mb-3"><i class="fas fa-check-circle text-success" style="font-size: 3.5rem;"></i></div>
            <h4 class="fw-bold mb-2">Konfirmasi Refund?</h4>
            <p class="text-muted mb-4">Apakah Anda yakin dana sudah ditransfer ke tamu?</p>
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                <button type="button" class="btn btn-success fw-bold px-4" style="border-radius: 8px;" id="btnConfirmRefund">Ya, Konfirmasi</button>
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
<script>
    window.financeChartData = {
        labels: {!! json_encode($chartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!},
        revenue: {!! json_encode($chartRevenue ?? [0,0,0,0,0,0]) !!},
        expense: {!! json_encode($chartExpense ?? [0,0,0,0,0,0]) !!},
        profit: {!! json_encode($chartProfit ?? [0,0,0,0,0,0]) !!}
    };
</script>
<script>
    let activeRefundId = null;

    function showRefundModal(id) {
        activeRefundId = id;
        new bootstrap.Modal(document.getElementById('refundConfirmModal')).show();
    }

    document.getElementById('btnConfirmRefund').addEventListener('click', function() {
        if (activeRefundId) {
            document.getElementById('refund-form-' + activeRefundId).submit();
        }
    });

    // Export Logic using SheetJS
    document.getElementById('exportForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const startDate = document.getElementById('exportStartDate').value;
        const endDate = document.getElementById('exportEndDate').value;
        let url = "{{ route('finance.export') }}?";
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

                // Create a new workbook and worksheet from the JSON data
                const worksheet = XLSX.utils.json_to_sheet(data);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Transactions");

                // Generate filename based on dates or current date
                let filename = "Laporan_Keuangan_Roomly";
                if (startDate && endDate) filename += "_" + startDate + "_to_" + endDate;
                else filename += "_" + new Date().toISOString().slice(0,10);
                filename += ".xlsx";

                // Trigger download
                XLSX.writeFile(workbook, filename);

                // Reset button and close modal
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
<script src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
<script src="{{ asset('assets/js/admin/finance.js') }}"></script>
</body>
</html>