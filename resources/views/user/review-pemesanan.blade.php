<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Pemesanan - Roomly</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/css/review-pemesanan.css') }}?v={{ time() }}">
</head>
<body>

<div class="page-header">
    <a href="javascript:void(0)" onclick="window.history.back()" class="back-arrow">&#10094;</a>
    <h1>Review Pemesanan</h1>
</div>

<div class="container">
    
    <form action="{{ route('user.review.store') }}" method="POST">
        @csrf

        <input type="hidden" name="room_name" value="{{ $roomName }}">
        <input type="hidden" name="option_type" value="{{ $optionType }}">
        <input type="hidden" name="price" value="{{ $pricePerNight }}">
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">

        <div class="booking-layout">
            
            <div class="main-content">

                @if ($errors->any())
                    <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 15px; border-radius: 8px; font-size: 0.9rem;">
                        <strong>Waduh, ada data yang belum lengkap:</strong>
                        <ul style="margin: 5px 0 0 20px; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="card">
                    <h3 class="card-title"><i class="fa-regular fa-envelope" style="color: #64748b;"></i> Data Pemesanan</h3>
                    <p class="card-subtitle">Isi semua kolom dengan benar untuk menerima konfirmasi pemesanan.</p>
                    
                    <div class="form-group">
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
                    <h3 class="card-title"><i class="fa-regular fa-user" style="color: #64748b;"></i> Informasi Pemesan</h3>
                    <p class="card-subtitle">Isi semua kolom dengan benar untuk menerima konfirmasi pesanan</p>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_pengunjung" class="form-control" value="Dimas Sudarmono">
                        <div class="input-desc">Sesuai KTP/paspor/SIM (tanpa tanda baca atau gelar).</div>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-title"><i class="fa-regular fa-file-lines" style="color: #64748b;"></i> Permintaan Khusus</h3>
                    <p class="card-subtitle" style="line-height: 1.5;">Semua permintaan khusus tergantung pada ketersediaan dan tidak dijamin. Check-in lebih awal atau antar-jemput bandara dapat dikenakan biaya tambahan. Silakan hubungi staf hotel secara langsung untuk informasi lebih lanjut.</p>
                    
                    <div class="checkbox-grid">
                        <div class="request-item-wrapper">
                            <label class="checkbox-item"><input type="checkbox" name="request[]" value="Kamar bebas asap rokok"> Kamar bebas asap rokok</label>
                        </div>
                        <div class="request-item-wrapper">
                            <label class="checkbox-item"><input type="checkbox" name="request[]" value="Kamar dengan pintu penghubung"> Kamar dengan pintu penghubung</label>
                        </div>
                        <div class="request-item-wrapper">
                            <label class="checkbox-item"><input type="checkbox" name="request[]" value="Lantai atas"> Lantai atas</label>
                        </div>
                        <div class="request-item-wrapper">
                            <label class="checkbox-item"><input type="checkbox" name="request[]" value="Tipe ranjang"> Tipe ranjang</label>
                        </div>
                        
                        <div class="request-item-wrapper">
                            <label class="checkbox-item"><input type="checkbox" id="chk-lainnya" name="request[]" value="Lainnya"> Lainnya</label>
                            <div id="box-lainnya" class="conditional-input-field">
                                <textarea name="request_lainnya_detail" class="form-control" placeholder="Tuliskan detail permintaan khusus lainnya di sini..." rows="2"></textarea>
                            </div>
                        </div>
                        
                        <div class="request-item-wrapper">
                            <label class="checkbox-item"><input type="checkbox" id="chk-checkin" name="request[]" value="Waktu check-in"> Waktu check-in</label>
                            <div id="box-checkin" class="conditional-input-field">
                                <input type="time" name="request_checkin_time" class="form-control time-picker-style" value="14:00">
                                <span class="input-desc">Tentukan perkiraan jam kedatangan Anda.</span>
                            </div>
                        </div>
                        
                        <div class="request-item-wrapper">
                            <label class="checkbox-item"><input type="checkbox" id="chk-checkout" name="request[]" value="Waktu check-out"> Waktu check-out</label>
                            <div id="box-checkout" class="conditional-input-field">
                                <input type="time" name="request_checkout_time" class="form-control time-picker-style" value="12:00">
                                <span class="input-desc">Tentukan perkiraan jam kepulangan Anda.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-title"><i class="fa-solid fa-list-check" style="color: #64748b;"></i> Kebijakan Akomodasi</h3>
                    <div class="policy-list" style="margin-top: 20px;">
                        <div class="policy-item">
                            <h4>👤 Usia minimum check-in</h4>
                            <p>Usia minimum untuk check-in adalah 18 tahun. Anak-anak harus didampingi orang dewasa saat check-in.</p>
                        </div>
                        <div class="policy-item">
                            <h4>🕒 Waktu check-in & check-out</h4>
                            <p>Waktu standar check-in adalah pukul 14:00 WIB dan check-out pukul 12:00 WIB. Early check-in atau late check-out mungkin dikenakan biaya tambahan.</p>
                        </div>
                        <div class="policy-item">
                            <h4>🪪 Identitas diri</h4>
                            <p>Tamu wajib menunjukkan kartu identitas resmi seperti KTP, SIM, atau Paspor saat check-in.</p>
                        </div>
                        <div class="policy-item">
                            <h4>🚭 Larangan merokok</h4>
                            <p>Tamu wajib mematuhi larangan merokok di area non-smoking.</p>
                        </div>
                        <div class="policy-item">
                            <h4>👥 Jumlah penghuni kamar</h4>
                            <p>Tamu tidak diizinkan melebihi kapasitas tempat tidur yang dipesan. Biaya tambahan biasanya berlaku untuk extra bed.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar-sticky">
                
                <div class="card" style="padding: 22px;">
                    <h3 style="font-size: 0.95rem; font-weight: 700; margin: 0; color: #1a1f2c;">(1x) {{ $roomName }} - {{ $optionType }}</h3>
                    
                    <div class="checkin-checkout-box">
                        <div class="time-box">
                            <h5>Check-in</h5>
                            <p>Kamis, 12 Mar 2026</p>
                            <span>Dari 14:00</span>
                        </div>
                        <div class="arrow-divider">&rarr;</div>
                        <div class="time-box" style="text-align: right;">
                            <h5>Check-out</h5>
                            <p>Jumat, 13 Mar 2026</p>
                            <span>Sebelum 12:00</span>
                        </div>
                    </div>

                    <div class="room-meta-icons">
                        <span><i class="fa-solid fa-users" style="color: #94a3b8; margin-right: 5px;"></i> 2 Tamu</span>
                        <span><i class="fa-solid fa-bed" style="color: #94a3b8; margin-right: 5px;"></i> 1 Bed</span>
                    </div>
                    <p style="font-size: 0.78rem; color: #dc2626; margin: 12px 0 0 0; font-weight: 500;"><i class="fa-solid fa-calendar-xmark" style="margin-right: 5px;"></i> Pemesanan ini tidak bisa di-refund.</p>
                    <p style="font-size: 0.78rem; color: #64748b; margin: 4px 0 0 0;"><i class="fa-solid fa-ban" style="margin-right: 5px;"></i> Non-reschedulable</p>
                    <p style="font-size: 0.78rem; color: #4ebd74; margin: 4px 0 0 0; font-weight: 500;"><i class="fa-solid fa-wifi" style="margin-right: 5px;"></i> Wi-Fi</p>
                </div>

                <div class="card" style="padding: 22px;">
                    <h3 class="card-title" style="font-size: 1rem; font-weight: 700;"><i class="fa-solid fa-tags" style="color: #64748b; font-size: 0.9rem;"></i> Rincian harga</h3>
                    
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-top: 18px;">
                        <span style="color: #64748b;">Harga kamar</span>
                        <strong style="color: #1a1f2c;">Rp. {{ number_format($pricePerNight, 0, ',', '.') }}</strong>
                    </div>
                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 2px; margin-bottom: 12px;">
                        (1x) {{ $roomName }} - {{ $optionType }}
                    </div>

                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 15px;">
                        <span style="color: #64748b;">Pajak dan Biaya</span>
                        <strong style="color: #1a1f2c;">Rp. {{ number_format($taxAndFee, 0, ',', '.') }}</strong>
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
                        Dengan lanjut ke pembayaran, kamu telah menyetujui Syarat dan Ketentuan, Kebijakan Privasi, dan Prosedur Refund Akomodasi dari Roomly.
                    </p>
                </div>

                <!-- Banner 1: Model Landscape Tipis -->
                <div class="banner-container banner-horizontal">
                    <img src="{{ asset('assets/img/hotel.png') }}" alt="Nu Milk Tea Banner Horizontal">
                </div>

                <!-- Banner 2: Model Kotak Taut / Vertikal -->
                <div class="banner-container banner-vertical">
                    <img src="{{ asset('assets/img/hotel2.png') }}" alt="Nu Milk Tea Banner Vertical">
                </div>
            </div>

        </div>
    </form>
</div>

<script src="{{ asset('assets/js/review-pemesanan.js') }}?v={{ time() }}"></script>

</body>
</html>