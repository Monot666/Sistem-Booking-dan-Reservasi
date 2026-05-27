<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Pemesanan - Roomly</title>
    <link rel="stylesheet" href="{{ asset('assets/css/review-pemesanan.css') }}">
</head>
<body>

<div class="page-header">
    <a href="#" class="back-arrow">&#10094;</a>
    <h1>Review Pemesanan</h1>
</div>

<div class="container">
    
    <form action="{{ route('user.review.store') }}" method="POST" style="display: contents;">
        @csrf

        <input type="hidden" name="room_name" value="{{ $roomName }}">
        <input type="hidden" name="option_type" value="{{ $optionType }}">
        <input type="hidden" name="price" value="{{ $pricePerNight }}">
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">

        <div class="main-content">

            @if ($errors->any())
                <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem;">
                    <strong>Waduh, ada data yang belum lengkap:</strong>
                    <ul style="margin: 5px 0 0 20px; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="card">
                <h3 class="card-title">&#9993; Data Pemesanan</h3>
                <p class="card-subtitle">Isi semua kolom dengan benar untuk menerima konfirmasi pemesanan.</p>
                
                <div class="form-group full-width">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_pemesan" class="form-control" value="Dimas Sudarmono" required>
                    <div class="input-desc">Sesuai KTP/Paspor/SIM (tanpa tanda baca atau gelar).</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>No. Handphone</label>
                        <input type="text" name="no_hp" class="form-control" value="087759315883" required>
                        <div class="input-desc">No. Handphone wajib diisi.</div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="dimas@gmail.com" required>
                        <div class="input-desc">Contoh: email@example.com</div>
                    </div>
                </div>

                <label class="checkbox-single">
                    <input type="checkbox" name="is_self_buyer" checked> Pesanan ini untuk saya
                </label>
            </div>

            <div class="card">
                <h3 class="card-title">&#128100; Informasi Pemesan</h3>
                <p class="card-subtitle">Isi semua kolom dengan benar untuk menerima konfirmasi pesanan</p>
                
                <div class="form-group full-width">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_pengunjung" class="form-control" value="Dimas Sudarmono">
                    <div class="input-desc">Sesuai KTP/paspor/SIM (tanpa tanda baca atau gelar).</div>
                </div>
            </div>

            <div class="card">
                <h3 class="card-title">&#128196; Permintaan Khusus</h3>
                <p class="card-subtitle" style="line-height: 1.4;">Semua permintaan khusus tergantung pada ketersediaan dan tidak dijamin. Check-in lebih awal atau antar-jemput bandara dapat dikenakan biaya tambahan. Silakan hubungi staf hotel secara langsung untuk informasi lebih lanjut.</p>
                
                <div class="checkbox-grid">
                    <label class="checkbox-item"><input type="checkbox" name="request[]" value="Kamar bebas asap rokok" checked> Kamar bebas asap rokok</label>
                    <label class="checkbox-item"><input type="checkbox" name="request[]" value="Kamar dengan pintu penghubung" checked> Kamar dengan pintu penghubung</label>
                    <label class="checkbox-item"><input type="checkbox" name="request[]" value="Lantai atas" checked> Lantai atas</label>
                    <label class="checkbox-item"><input type="checkbox" name="request[]" value="Tipe ranjang" checked> Tipe ranjang</label>
                    <label class="checkbox-item"><input type="checkbox" name="request[]" value="Lainnya" checked> Lainnya</label>
                    <label class="checkbox-item"><input type="checkbox" name="request[]" value="Waktu check-in" checked> Waktu check-in</label>
                    <label class="checkbox-item"><input type="checkbox" name="request[]" value="Waktu check-out" checked> Waktu check-out</label>
                </div>
            </div>

            <div class="card">
                <h3 class="card-title">&#128203; Kebijakan Akomodasi</h3>
                <div class="policy-list">
                    <div class="policy-item">
                        <h4>&#128696; Usia minimum check-in</h4>
                        <p>Usia minimum untuk check-in adalah 18 tahun. Anak-anak harus didampingi orang dewasa saat check-in.</p>
                    </div>
                    <div class="policy-item">
                        <h4>&#128338; Waktu check-in & check-out</h4>
                        <p>Waktu standar check-in adalah pukul 14:00 WIB dan check-out pukul 12:00 WIB. Early check-in atau late check-out mungkin dikenakan biaya tambahan.</p>
                    </div>
                    <div class="policy-item">
                        <h4>&#128100; Identitas diri</h4>
                        <p>Tamu wajib menunjukkan kartu identitas resmi seperti KTP, SIM, atau Paspor saat check-in.</p>
                    </div>
                    <div class="policy-item">
                        <h4>&#128684; Larangan merokok</h4>
                        <p>Tamu wajib mematuhi larangan merokok di area non-smoking.</p>
                    </div>
                    <div class="policy-item">
                        <h4>&#128101; Jumlah penghuni kamar</h4>
                        <p>Tamu tidak diizinkan melebihi kapasitas tempat tidur yang dipesan. Biaya tambahan biasanya berlaku untuk extra bed.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-sticky">
            
            <div class="card">
                <h3 class="card-title" style="font-size: 1.15rem;">(1x) {{ $roomName }} - {{ $optionType }}</h3>
                
                <div class="checkin-checkout-box">
                    <div class="time-box">
                        <h5>Check-in</h5>
                        <p>Kamis, 12 Maret 2026</p>
                        <span>Dari 14:00</span>
                    </div>
                    <div class="arrow-divider">&rarr;</div>
                    <div class="time-box" style="text-align: right;">
                        <h5>Check-out</h5>
                        <p>Jumat, 13 Maret 2026</p>
                        <span>Sebelum 12:00</span>
                    </div>
                </div>

                <div class="room-meta-icons">
                    &#128101; 2 Tamu &nbsp;|&nbsp; &#128143; &nbsp;|&nbsp; &#128684;
                </div>
                <p style="font-size: 0.8rem; color: #dc2626; margin: 6px 0;">&#128197; Pemesanan ini tidak bisa di-refund.</p>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 6px 0;">&#128197; Non-reschedulable</p>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 6px 0;">&#128242; Wi-Fi</p>
            </div>

            <div class="card" style="padding-bottom: 15px;">
                <h3 class="card-title" style="font-size: 1.2rem;">&#127183; Rincian harga</h3>
                
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-top: 15px;">
                    <span style="color: var(--text-muted);">Harga kamar</span>
                    <strong>Rp. {{ number_format($pricePerNight, 0, ',', '.') }}</strong>
                </div>
                <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; margin-bottom: 12px;">
                    (1x) {{ $roomName }} - {{ $optionType }}
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 15px;">
                    <span style="color: var(--text-muted);">Pajak dan Biaya</span>
                    <strong>Rp. {{ number_format($taxAndFee, 0, ',', '.') }}</strong>
                </div>

                <div class="total-highlight-box">
                    <div class="total-left">
                        <h4>Total</h4>
                        <p>1 kamar, 1 malam</p>
                    </div>
                    <div class="total-right">
                        Rp. {{ number_format($totalPrice, 0, ',', '.') }}
                    </div>
                </div>

                <button type="submit" class="btn-submit-booking">Lanjutkan</button>
                
                <p class="submit-footer-notice">
                    Dengan lanjut ke pembayaran, kamu telah menyetujui menyetujui Syarat dan Ketentuan, Kebijakan Privasi, dan Prosedur Refund Akomodasi dari Roomly.
                </p>
            </div>

            <div class="banner-container">
                <img src="{{ asset('assets/img/bg login.png') }}" alt="Nu Milk Tea Banner">
            </div>
        </div>

    </form>
</div>

</body>
</html>