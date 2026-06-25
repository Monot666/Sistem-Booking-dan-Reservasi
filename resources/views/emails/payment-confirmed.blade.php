<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Berhasil - Informasi Kamar Anda</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="color: #4CAF50;">🎉 Pembayaran Berhasil!</h2>
        <p>Terima kasih telah memilih <strong>Roomly</strong> untuk tempat Anda menginap.</p>
    </div>

    <div style="background-color: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
        <h3 style="margin-top: 0;">Detail Reservasi Kamar</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Nama Pemesan</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">{{ $booking->nama_pemesan }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>No Pesanan</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">#{{ $booking->no_pesanan }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Tipe Kamar</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">{{ $booking->room_name }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee; color: #E53935; font-size: 1.2em;"><strong>NOMOR KAMAR ANDA</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right; color: #E53935; font-size: 1.2em; font-weight: bold;">
                    {{ $booking->roomUnit->room_number ?? '' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Tanggal Check-in</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #eee; text-align: right;">{{ $booking->start_time->format('d M Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Tanggal Check-out</strong></td>
                <td style="padding: 8px 0; text-align: right;">{{ $booking->end_time->format('d M Y') }}</td>
            </tr>
        </table>
    </div>

    <p style="margin-top: 30px;">
        Silakan tunjukkan email ini kepada resepsionis saat melakukan proses check-in sebagai bukti reservasi kamar fisik Anda.
    </p>

    <p style="color: #888; font-size: 0.9em; text-align: center; margin-top: 50px;">
        &copy; {{ date('Y') }} Roomly Luxury Hotel & Resort. All rights reserved.
    </p>
</body>
</html>
