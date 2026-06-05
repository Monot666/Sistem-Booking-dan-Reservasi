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
$transactions = [
    ['id' => 1, 'date' => '12-03-2026', 'desc' => 'Room Booking - BK001', 'category' => 'Revenue', 'amount' => 535000, 'method' => 'Virtual Account', 'status' => 'Completed'],
    ['id' => 2, 'date' => '12-03-2026', 'desc' => 'Staff Salaries - Praya', 'category' => 'Expense', 'amount' => 5000000, 'method' => 'Bank Transfer', 'status' => 'Completed'],
    ['id' => 3, 'date' => '12-03-2026', 'desc' => 'Room Booking - BK002', 'category' => 'Revenue', 'amount' => 535000, 'method' => 'Paypal', 'status' => 'Completed'],
    ['id' => 4, 'date' => '12-03-2026', 'desc' => 'Maintenance Supplies', 'category' => 'Expense', 'amount' => 1000000, 'method' => 'Virtual Account', 'status' => 'Completed'],
    ['id' => 5, 'date' => '12-03-2026', 'desc' => 'Room Booking - BK001', 'category' => 'Revenue', 'amount' => 535000, 'method' => 'Virtual Account', 'status' => 'Completed'],
    ['id' => 6, 'date' => '12-03-2026', 'desc' => 'Room Booking - BK001', 'category' => 'Revenue', 'amount' => 535000, 'method' => 'Virtual Account', 'status' => 'Completed'],
    ['id' => 7, 'date' => '12-03-2026', 'desc' => 'Booking Cancellation', 'category' => 'Refund', 'amount' => 535000, 'method' => 'Credit Card', 'status' => 'Completed'],
    ['id' => 8, 'date' => '12-03-2026', 'desc' => 'Room Booking - BK001', 'category' => 'Revenue', 'amount' => 535000, 'method' => 'Virtual Account', 'status' => 'Completed'],
];
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
                <button class="btn-save-data" id="btnSaveData">
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
                    <div class="stat-amount">Rp 4.390.000</div>
                    <div class="stat-desc">+12% from last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card solid-red">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="stat-title">Total Expenses</span>
                        <i class="fas fa-arrow-trend-down"></i>
                    </div>
                    <div class="stat-amount">Rp 19.050.000</div>
                    <div class="stat-desc">+5% from last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card solid-gold">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="stat-title">Net Profit</span>
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="stat-amount">Rp 15.200.000</div>
                    <div class="stat-desc">Profit Margin: +67.2%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card solid-dark">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="stat-title">Transactions</span>
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div class="stat-amount">58</div>
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
                            <td>{{ $t['date'] }}</td>
                            <td class="text-start fw-medium" style="color: #334155;">{{ $t['desc'] }}</td>
                            <td>
                                <span class="badge-cat {{ strtolower($t['category']) }}">{{ $t['category'] }}</span>
                            </td>
                            <td class="fw-semibold" style="color: {{ $t['category'] == 'Expense' || $t['category'] == 'Refund' ? '#ef4444' : '#10b981' }}">
                                Rp. {{ number_format($t['amount'], 0, ',', '.') }}
                            </td>
                            <td>{{ $t['method'] }}</td>
                            <td>
                                <span class="badge-status">Completed</span>
                            </td>
                            <td>
                                <button class="btn-action-detail" data-bs-toggle="modal" data-bs-target="#detailModal{{ $t['id'] }}">
                                    <i class="fas fa-ellipsis-h"></i>
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

@foreach($transactions as $t)
<div class="modal fade" id="detailModal{{ $t['id'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="color: #1e293b;">Transaction Details</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Transaction ID:</span>
                    <span class="fw-bold text-dark">#TXN-00{{ $t['id'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Date:</span>
                    <span class="fw-bold text-dark">{{ $t['date'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Description:</span>
                    <span class="fw-bold text-dark text-end">{{ $t['desc'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Category:</span>
                    <span class="badge-cat {{ strtolower($t['category']) }}">{{ $t['category'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Payment Method:</span>
                    <span class="fw-bold text-dark">{{ $t['method'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                    <span class="text-muted" style="font-size: 0.9rem;">Status:</span>
                    <span class="badge-status">{{ $t['status'] }}</span>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <span class="text-muted fw-bold">Total Amount:</span>
                    <span class="fw-bold fs-5" style="color: {{ $t['category'] == 'Expense' || $t['category'] == 'Refund' ? '#ef4444' : '#10b981' }}">
                        Rp. {{ number_format($t['amount'], 0, ',', '.') }}
                    </span>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn w-100" data-bs-dismiss="modal" style="background-color: #f1f5f9; color: #475569; font-weight: 600; border-radius: 8px;">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; padding: 10px;">
            <div class="modal-header border-0 pb-0">
                <h4 class="modal-title fw-bold" style="color: #1e293b;">Add New Transaction</h4>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
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
                        <select class="form-select custom-form-input" name="category" required>
                            <option value="" disabled selected hidden>Select Category</option>
                            <option value="Revenue">Revenue</option>
                            <option value="Expense">Expense</option>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/finance/finance.js') }}"></script>
</body>
</html>