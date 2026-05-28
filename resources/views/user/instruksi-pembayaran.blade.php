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

    // Penentuan generator nomor invoice tiruan sesuai metode klik user
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
    } else {
        $nomorKodeBayar = "PROCESSED-BY-GATEWAY";
    }
@endphp

<div class="status-page-wrapper">
    <div class="status-container">
        <div class="status-card pending-mode">
            
            <div class="status-icon-header alert-orange">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            
            <h1 class="main-status-title">Selesaikan Pembayaran</h1>
            <p class="status-subtitle">Kamar pilihan Anda telah dikunci. Silakan lakukan penyelesaian transaksi sesuai detail petunjuk tagihan di bawah ini.</p>

            <!-- KOTAK CORES: REKENING / VA / KODE TAGIHAN -->
            <div class="payment-code-highlight-box">
                @if($method === 'MINIMARKET')
                    <span class="code-label">KODE PEMBAYARAN KASIR ({{ $mart }})</span>
                @elseif($method === 'TRANSFER')
                    <span class="code-label">NOMOR REKENING MANUAL (MANDIRI)</span>
                @elseif($method === 'VA')
                    <span class="code-label">NOMOR VIRTUAL ACCOUNT ({{ $bank }})</span>
                @else
                    <span class="code-label">KODE INVOICE TRANSAKSI ({{ $method }})</span>
                @endif
                
                <div class="code-numeric-flex">
                    <input type="text" id="target-pay-code" value="{{ $nomorKodeBayar }}" readonly>
                    <button type="button" class="btn-copy-code" onclick="copyPaymentCode()">
                        <i class="fa-regular fa-copy"></i> Salin
                    </button>
                </div>
                <p class="merchant-notice">Total Tagihan: <strong>Rp. 535.000</strong></p>
            </div>

            <!-- DEADLINE BANNER TIMER -->
            <div class="deadline-timer-banner">
                <div class="dl-left"><i class="fa-regular fa-clock"></i> Batas Waktu Penyelesaian</div>
                <div class="dl-right" id="deadline-clock">23:59:59</div>
            </div>

            <!-- DETAIL STEP INSTRUKSI BERDASARKAN METODE -->
            <div class="guide-steps-box">
                <h3><i class="fa-solid fa-list-check"></i> Panduan Langkah Transfer:</h3>
                <ol>
                    @if($method === 'MINIMARKET')
                        <li>Kunjungi gerai <strong>{{ $mart }}</strong> terdekat sebelum waktu batas habis.</li>
                        <li>Sampaikan pada kasir: <em>"Mau bayar tagihan transaksi Roomly"</em>.</li>
                        <li>Tunjukkan <strong>Kode Pembayaran</strong> di atas ke kasir.</li>
                        <li>Bayar tunai/debit sebesar Rp 535.000 dan simpan struk fisik dari kasir.</li>
                    @elseif($method === 'TRANSFER')
                        <li>Lakukan transfer manual ke Rekening Mandiri Roomly: <strong>1234567890987</strong>.</li>
                        <li>Pastikan nama penerima: <strong>PT Roomly Global Indonesia</strong>.</li>
                        <li>Masukkan nominal presisi sebesar Rp 535.000.</li>
                        <li>Simpan bukti transfer untuk divalidasi oleh tim keuangan Roomly.</li>
                    @elseif($method === 'VA')
                        <li>Buka M-Banking atau kunjungi mesin ATM bank <strong>{{ $bank }}</strong> Anda.</li>
                        <li>Masuk ke menu <strong>Transfer > Virtual Account</strong>.</li>
                        <li>Masukkan nomor VA resmi Anda: <strong>{{ $nomorKodeBayar }}</strong>.</li>
                        <li>Konfirmasi nama penerima (<strong>Roomly - Dimas S.</strong>) lalu masukkan PIN transaksi Anda.</li>
                    @else
                        <li>Gunakan kode invoice transaksi untuk menyelesaikan pemesanan lewat kanal merchant terpilih.</li>
                        <li>Pastikan jumlah nominal dana tidak kurang dan tidak lebih dari Rp 535.000.</li>
                    @endif
                </ol>
            </div>

            <!-- ACTION REDIRECT BUTTONS -->
            <div class="action-footer-group" style="margin-top: 25px;">
                <a href="{{ route('user.pembayaran.sukses', ['method' => $method]) }}" class="btn-status-primary" style="background-color: #10b981; border-color: #10b981;">
                    <i class="fa-solid fa-circle-check"></i> Saya Sudah Bayar
                </a>
                <a href="{{ route('booking') }}" class="btn-status-secondary">Bayar Nanti (Ke Beranda)</a>
            </div>

        </div>
    </div>
</div>

<script>
    function copyPaymentCode() {
        const copyText = document.getElementById("target-pay-code");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        alert("Berhasil disalin: " + copyText.value);
    }

    // Hitung mundur tiruan 24 Jam
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