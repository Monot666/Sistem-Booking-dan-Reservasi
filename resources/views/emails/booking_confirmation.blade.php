<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Booking - Roomly</title>
</head>
<body style="margin:0; padding:0; background:#f4f4f4; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background:#0a0a0a; color:#ffffff; padding:30px; text-align:center;">
                            <h1 style="margin:0; font-size:24px; letter-spacing: 2px;">ROOMLY</h1>
                            <p style="margin:10px 0 0; color:#e6a04d; font-weight:bold;">KONFIRMASI BOOKING</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px;">
                            <h2 style="color:#333; margin-top:0;">Halo, {{ $booking->user->name }}!</h2>
                            <p style="color:#666; line-height:1.6;">
                                Terima kasih telah melakukan pemesanan di Roomly. Pesanan Anda telah kami terima dan saat ini sedang dalam status <strong>PENDING</strong>.
                            </p>
                            
                            <div style="background:#f9f9f9; border-left:4px solid #e6a04d; padding:20px; margin:30px 0;">
                                <h3 style="margin-top:0; color:#333; font-size:16px;">Detail Pesanan:</h3>
                                <table width="100%" style="color:#555; font-size:14px;">
                                    <tr>
                                        <td width="150" style="padding:5px 0;"><strong>Ruangan</strong></td>
                                        <td>: {{ $booking->resource->name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 0;"><strong>Check-in</strong></td>
                                        <td>: {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 0;"><strong>Check-out</strong></td>
                                        <td>: {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:5px 0;"><strong>Total Harga</strong></td>
                                        <td style="color:#e6a04d; font-weight:bold;">: Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <p style="color:#666; line-height:1.6;">
                                Silakan segera lakukan pembayaran untuk mengonfirmasi pesanan Anda. Klik tombol di bawah ini untuk langsung menuju halaman pembayaran.
                            </p>

                            <div style="text-align:center; margin-top:30px;">
                                <a href="{{ url('/bookings/' . $booking->id . '/payment') }}" style="background:#e6a04d; color:#ffffff; padding:16px 40px; text-decoration:none; border-radius:30px; font-weight:bold; display:inline-block; font-size:15px; letter-spacing:1px;">BAYAR SEKARANG</a>
                            </div>

                            <div style="text-align:center; margin-top:15px;">
                                <a href="{{ url('/profile/orders') }}" style="background:#0a0a0a; color:#ffffff; padding:12px 30px; text-decoration:none; border-radius:30px; font-weight:bold; display:inline-block; font-size:13px;">LIHAT PESANAN SAYA</a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f9f9f9; padding:20px; text-align:center; font-size:12px; color:#999; border-top:1px solid #eee;">
                            &copy; 2026 Roomly. All Rights Reserved.<br>
                            Jl. Raya Roomly No. 123, Indonesia
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
