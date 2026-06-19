<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengembalian Dana (Refund) Selesai</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; margin: 0; padding: 20px; color: #334155; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .email-header { background-color: #10b981; padding: 30px 20px; text-align: center; color: white; }
        .email-header h1 { margin: 0; font-size: 24px; }
        .email-body { padding: 30px; }
        .email-body p { line-height: 1.6; font-size: 16px; margin-bottom: 20px; }
        .details-box { background-color: #f1f5f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .details-box h3 { margin-top: 0; margin-bottom: 15px; color: #1e293b; font-size: 18px; border-bottom: 1px solid #cbd5e1; padding-bottom: 10px; }
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .detail-label { color: #64748b; font-weight: 500; }
        .detail-value { font-weight: bold; color: #1e293b; text-align: right; }
        .total-amount { font-size: 20px; color: #10b981; font-weight: bold; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #cbd5e1; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; color: #94a3b8; font-size: 14px; border-top: 1px solid #e2e8f0; }
        .footer a { color: #3b82f6; text-decoration: none; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Refund Dikonfirmasi</h1>
        </div>
        <div class="email-body">
            <p>Halo <strong>{{ $booking->user->name ?? $booking->nama_pemesan }}</strong>,</p>
            <p>Kabar gembira! Tim Keuangan kami telah berhasil memproses dan mentransfer kembali pengembalian dana (refund) untuk pesanan Anda yang dibatalkan.</p>
            
            <div class="details-box">
                <h3>Rincian Pembatalan</h3>
                <div class="detail-row">
                    <span class="detail-label">ID Pesanan:</span>
                    <span class="detail-value">#BK{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Akomodasi:</span>
                    <span class="detail-value">{{ $booking->room_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Alasan Pembatalan:</span>
                    <span class="detail-value">{{ $booking->refund_reason }}</span>
                </div>
                <div class="detail-row total-amount">
                    <span class="detail-label" style="color: #10b981;">Total Dana Dikembalikan:</span>
                    <span class="detail-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <p>Silakan periksa mutasi rekening / e-wallet Anda yang digunakan saat memesan (biasanya memakan waktu 1-3 hari kerja tergantung bank). Jika Anda mengalami kendala, jangan ragu untuk menghubungi layanan pelanggan kami.</p>
            
            <p>Terima kasih atas pengertian Anda dan kami menantikan kehadiran Anda kembali di Roomly!</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Roomly. All rights reserved.<br>
            <a href="{{ url('/') }}">Kunjungi Website Kami</a>
        </div>
    </div>
</body>
</html>
