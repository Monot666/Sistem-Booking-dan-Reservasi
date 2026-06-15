<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran - Roomly</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sukses-pembayaran.css') }}?v={{ time() }}">
</head>
<body>

@php
    $method = strtoupper(request('method', 'VA')); 
    $bank = strtoupper(request('bank', 'BCA'));
    $mart = strtoupper(request('mart', 'ALFAMART'));

    $nomorKodeBayar = "8837308775931586"; 
    if ($method === 'VA') {
        if ($bank === 'MANDIRI') $nomorKodeBayar = "8950808775931586";
        if ($bank === 'BRI') $nomorKodeBayar = "1280008775931586";
        if ($bank === 'BNI') $nomorKodeBayar = "9880008775931586";
        if ($bank === 'CIMB') $nomorKodeBayar = "7033008775931586";
    } elseif ($method === 'TRANSFER') {
        $nomorKodeBayar = "1234567890987";
    } elseif ($method === 'MINIMARKET') {
        $nomorKodeBayar = "RM-987759315";
    } elseif ($method === 'ATM') {
        $nomorKodeBayar = "KODE-ATM-9875";
    }

    $bookingId = request('booking_id');
    $booking = $bookingId ? \App\Models\Booking::find($bookingId) : null;
    $totalPrice = $booking ? $booking->total_price : 0;
@endphp

<div class="page-header" style="padding: 20px; display: flex; align-items: center; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
    <a href="{{ route('bookings.payment', ['id' => $bookingId ?? 1]) }}" class="back-arrow" style="text-decoration: none; color: #333; font-size: 1.2rem; margin-right: 15px;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h1 style="font-size: 1.2rem; margin: 0;">Selesaikan Pembayaran</h1>
</div>

<div class="status-page-wrapper">
    <div class="status-container">
        <div class="status-card pending-mode">
            
            <div class="status-icon-header alert-orange">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            
            <h1 class="main-status-title">Selesaikan Pembayaran</h1>
            <p class="status-subtitle">Kamar pilihan Anda telah dikunci. Silakan lakukan penyelesaian transaksi sesuai detail petunjuk tagihan di bawah ini.</p>

            <div class="payment-code-highlight-box">
                @if($method === 'MINIMARKET')
                    <span class="code-label">KODE PEMBAYARAN KASIR ({{ $mart }})</span>
                @elseif($method === 'TRANSFER')
                    <span class="code-label">NOMOR REKENING MANUAL</span>
                @elseif($method === 'VA')
                    <span class="code-label">NOMOR VIRTUAL ACCOUNT ({{ $bank }})</span>
                @else
                    <span class="code-label">KODE INVOICE ({{ $method }})</span>
                @endif
                
                <div class="code-numeric-flex">
                    <input type="text" id="target-pay-code" value="{{ $nomorKodeBayar }}" readonly style="width: 100%; border: none; font-weight: bold; font-size: 1.2rem;">
                    <button type="button" class="btn-copy-code" onclick="copyPaymentCode()">
                        <i class="fa-regular fa-copy"></i> Salin
                    </button>
                </div>
                <p class="merchant-notice">Total Tagihan: <strong>Rp. {{ number_format($totalPrice, 0, ',', '.') }}</strong></p>
            </div>

            <div class="deadline-timer-banner">
                <div class="dl-left"><i class="fa-regular fa-clock"></i> Batas Waktu Penyelesaian</div>
                <div class="dl-right" id="deadline-clock">23:59:59</div>
            </div>

            <div class="guide-steps-box">
                <h3><i class="fa-solid fa-list-check"></i> Panduan Langkah Transfer:</h3>
                <ol>
                    @if($method === 'MINIMARKET')
                        <li>Kunjungi gerai <strong>{{ $mart }}</strong> terdekat sebelum waktu batas habis.</li>
                        <li>Sampaikan pada kasir: <em>"Mau bayar tagihan transaksi Roomly"</em>.</li>
                        <li>Tunjukkan <strong>Kode Pembayaran</strong> di atas ke kasir.</li>
                    @elseif($method === 'TRANSFER')
                        <li>Transfer ke Rekening Mandiri: <strong>1234567890987</strong>.</li>
                        <li>Pastikan nominal presisi sebesar Rp {{ number_format($totalPrice, 0, ',', '.') }}.</li>
                    @elseif($method === 'VA')
                        <li>Buka M-Banking/ATM <strong>{{ $bank }}</strong>.</li>
                        <li>Pilih menu <strong>Transfer > Virtual Account</strong>.</li>
                        <li>Masukkan nomor: <strong>{{ $nomorKodeBayar }}</strong>.</li>
                    @else
                        <li>Selesaikan pembayaran melalui metode yang Anda pilih.</li>
                    @endif
                </ol>
            </div>

            <div class="action-footer-group" style="margin-top: 25px;">
                <a href="{{ route('bookings.payment.success', ['method' => $method]) }}" class="btn-status-primary" style="display:block; text-align:center; padding: 12px; background-color: #10b981; color: #fff; text-decoration: none; border-radius: 8px;">
                    <i class="fa-solid fa-circle-check"></i> Saya Sudah Bayar
                </a>
                <a href="{{ route('bookings.index') }}" style="display:block; text-align:center; margin-top: 10px; color: #666; text-decoration: none;">Bayar Nanti (Ke Beranda)</a>
            </div>

        </div>
    </div>
</div>

<script>
    function copyPaymentCode() {
        const copyText = document.getElementById("target-pay-code");
        copyText.select();
        navigator.clipboard.writeText(copyText.value);
        alert("Berhasil disalin: " + copyText.value);
    }

    let hours = 23, minutes = 59, seconds = 59;
    setInterval(() => {
        seconds--;
        if(seconds < 0) { seconds = 59; minutes--; }
        if(minutes < 0) { minutes = 59; hours--; }
        document.getElementById('deadline-clock').innerText = 
            (hours<10?'0':'')+hours + ":" + (minutes<10?'0':'')+minutes + ":" + (seconds<10?'0':'')+seconds;
    }, 1000);
</script>

</body>
</html>