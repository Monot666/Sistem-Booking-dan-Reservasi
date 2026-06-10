<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Roomly</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sukses-pembayaran.css') }}?v={{ time() }}">
</head>
<body>

@php
    $method = request('method', 'VA');
@endphp

<div class="status-page-wrapper">
    <div class="status-container">
        
        <!-- INSTANT SUCCESS CONTENT CARD -->
        <div class="status-card success-mode">
            <div class="status-icon-header success-green">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            
            <h1 class="main-status-title">Pembayaran Dikonfirmasi!</h1>
            <p class="status-subtitle">Terima kasih, finansial Roomly telah berhasil memverifikasi dana Anda. E-Voucher akomodasi Anda saat ini telah aktif sepenuhnya.</p>

            <div class="receipt-summary-box">
                <div class="receipt-row">
                    <span>No. Pemesanan</span>
                    <strong>RM-2026031299</strong>
                </div>
                <div class="receipt-row">
                    <span>Akomodasi</span>
                    <strong>Aston Hotel Solo</strong>
                </div>
                <div class="receipt-row">
                    <span>Metode Pembayaran</span>
                    <strong>{{ strtoupper($method) }} (Terverifikasi Otomatis)</strong>
                </div>
                <div class="divider-receipt"></div>
                <div class="receipt-row total-row-style">
                    <span>Status Transaksi</span>
                    <span class="price-green" style="color: #10b981; font-weight: bold;">LUNAS</span>
                </div>
            </div>

            <div class="action-footer-group">
                <a href="#" class="btn-status-primary" onclick="alert('E-Voucher berhasil diunduh ke folder download!')">
                    <i class="fa-solid fa-download"></i> Unduh Voucher Hotel
                </a>
                <a href="{{ route('bookings.index') }}" class="btn-status-secondary">Kembali ke Beranda</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>