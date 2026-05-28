<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Roomly</title>
    <link rel="stylesheet" href="{{ asset('assets/css/pembayaran.css') }}">
   
</head>
<body>

<div class="page-header">
    <a href="{{ route('user.review') }}" class="back-arrow">&#10094;</a>
    <h1>Pembayaran</h1>
</div>

<div class="container">
    
    <div class="main-content">
        
        <div class="timer-alert">
            <span>Tenang, harganya tidak akan berubah. Yuk selesaikan pembayaran dalam</span>
            <span class="timer-count" id="countdown-timer">00:15:00</span>
        </div>

        <form action="#" method="POST">
            @csrf

            <div class="card">
                <h3 class="card-title">Mau bayar pakai metode apa?</h3>
                
                <div class="accordion-group">
                    
                    <details class="accordion-item" open>
                        <summary class="accordion-header">
                            <div class="accordion-header-left">
                                <span>💳 Virtual Account</span>
                            </div>
                            <span class="arrow-indicator">&blacktriangledown;</span>
                        </summary>
                        <div class="accordion-content">
                            <label class="payment-option">
                                <span>BCA Virtual Account</span>
                                <input type="radio" name="payment_method" value="BCA_VA" checked>
                            </label>
                            <label class="payment-option">
                                <span>Mandiri Virtual Account</span>
                                <input type="radio" name="payment_method" value="MANDIRI_VA">
                            </label>
                            <label class="payment-option">
                                <span>BRI Virtual Account (BRIVA)</span>
                                <input type="radio" name="payment_method" value="BRI_VA">
                            </label>
                        </div>
                    </details>

                    <details class="accordion-item">
                        <summary class="accordion-header">
                            <div class="accordion-header-left">
                                <span>🏦 Transfer dari semua bank</span>
                            </div>
                            <span class="arrow-indicator">&blacktriangledown;</span>
                        </summary>
                        <div class="accordion-content">
                            <p style="font-size: 0.85rem; color: #666; margin-bottom: 12px;">
                                Kamu bisa mentransfer secara manual dari mesin ATM atau m-Banking ke rekening penampungan Roomly.
                            </p>
                            <label class="payment-option" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #edf2f7; cursor: pointer;">
                                <span>Transfer Bank Mandiri</span>
                                <input type="radio" name="payment_method" value="TRANSFER_MANDIRI">
                            </label>
                            <label class="payment-option" style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #edf2f7; cursor: pointer;">
                                <span>Transfer Bank BNI</span>
                                <input type="radio" name="payment_method" value="TRANSFER_BNI">
                            </label>
                            <label class="payment-option" style="display: flex; justify-content: space-between; padding: 10px 0; cursor: pointer;">
                                <span>Transfer Bank Permata</span>
                                <input type="radio" name="payment_method" value="TRANSFER_PERMATA">
                            </label>
                        </div>
                    </details>

                    <details class="accordion-item">
                        <summary class="accordion-header">
                            <div class="accordion-header-left">
                                <span>💳 Kartu Kredit/Debit</span>
                            </div>
                            <span class="arrow-indicator">&blacktriangledown;</span>
                        </summary>
                        <div class="accordion-content">
                            <p style="font-size: 0.85rem; color: #666; margin-bottom: 12px;">
                                Mendukung pembayaran aman menggunakan kartu berlogo Visa, MasterCard, dan JCB.
                            </p>
                            <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;">
                                <label style="font-size: 0.85rem; color: #4a5568; display: flex; align-items: center; gap: 8px;">
                                    <input type="radio" name="payment_method" value="CREDIT_CARD">
                                    <span>Gunakan Kartu Kredit / Debit</span>
                                </label>
                                <input type="text" name="card_number" placeholder="Nomor Kartu (16 digit)" maxlength="16" style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 0.85rem; box-sizing: border-box;">
                                <div style="display: flex; gap: 10px;">
                                    <input type="text" name="card_expiry" placeholder="MM/YY" maxlength="5" style="width: 50%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 0.85rem; box-sizing: border-box;">
                                    <input type="password" name="card_cvv" placeholder="CVV (3 digit)" maxlength="3" style="width: 50%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 0.85rem; box-sizing: border-box;">
                                </div>
                            </div>
                        </div>
                    </details>

                </div>
            </div>

            <div class="card" style="padding: 18px 24px; display: flex; justify-content: space-between; align-items: center; cursor: pointer;">
                <span style="font-weight: 600; color: #4a5568;">🎟️ Pakai kupon/kode promo</span>
                <span style="color: #a0aec0; font-weight: bold;">&rsaquo;</span>
            </div>

            <div class="card">
                <h3 class="card-title">Rincian harga</h3>
                
                <div class="price-row">
                    <span>Harga kamar</span>
                    <strong>Rp. {{ number_format($pemesanan->price_per_night, 0, ',', '.') }}</strong>
                </div>
                <div style="font-size: 0.8rem; color: #888; margin-top: -10px; margin-bottom: 15px;">
                    (1x) {{ $pemesanan->room_name }} - {{ $pemesanan->option_type }}
                </div>

                <div class="price-row">
                    <span>Pajak dan Biaya</span>
                    <strong>Rp. {{ number_format($pemesanan->tax_and_fee, 0, ',', '.') }}</strong>
                </div>

                <div class="total-highlight-box">
                    <div class="total-left">
                        <h4>Total</h4>
                        <p>1 kamar, 1 malam</p>
                    </div>
                    <div class="total-right">
                        Rp. {{ number_format($pemesanan->total_price, 0, ',', '.') }}
                    </div>
                </div>

                <button type="submit" class="btn-primary-booking">Lanjutkan</button>
                
                <p class="notice-text">
                    Dengan lanjut ke pembayaran, kamu telah menyetujui Syarat dan Ketentuan, Kebijakan Privasi, dan Prosedur Refund Akomodasi dari Roomly.
                </p>
            </div>
        </form>

    </div>

    <div class="sidebar-sticky">
        <div class="card">
            <div class="hotel-header-box">
                <h3 class="hotel-title">Aston Hotel Solo</h3>
                <div class="booking-id-text">No. Pesanan: <strong>{{ $pemesanan->no_pesanan }}</strong></div>
            </div>

            <div class="room-type-title">(1x) {{ $pemesanan->room_name }} - {{ $pemesanan->option_type }}</div>
            
            <div class="room-meta-info">
                <strong>Nama Pengunjung:</strong> {{ $pemesanan->nama_pengunjung }} <br>
                <strong>Permintaan:</strong> {{ $pemesanan->permintaan_khusus }}
            </div>

            <div style="background-color: #f8fafc; border-radius: 6px; padding: 12px; font-size: 0.85rem; line-height: 1.5; color: #4a5568;">
                <span style="font-weight: 600; display: block; margin-bottom: 4px; color: #2d3748;">Detail Kontak Pemesan:</span>
                👤 {{ $pemesanan->nama_pemesan }} <br>
                📞 {{ $pemesanan->no_hp }} <br>
                ✉️ {{ $pemesanan->email }}
            </div>
        </div>

        <div class="banner-container">
            <img src="{{ asset('assets/img/bg login.png') }}" alt="Banner 1">
            <img src="{{ asset('assets/img/bg login.png') }}" alt="Banner 2">
        </div>
    </div>

</div>

</body>
</html>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            let timeInMinutes = 15;
            let currentTime = timeInMinutes * 60;

            const timerElement = document.getElementById('countdown-timer');

            if (timerElement) {
                function startTimer() {
                    let minutes = Math.floor(currentTime / 60);
                    let seconds = currentTime % 60;

                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    seconds = seconds < 10 ? '0' + seconds : seconds;

                    timerElement.innerHTML = `00:${minutes}:${seconds}`;
                    
                    if (currentTime > 0) {
                        currentTime--;
                    } else {
                        clearInterval(timerInterval);
                        timerElement.innerHTML = "WAKTU HABIS";
                        alert("Waktu pembayaran telah habis. Silakan lakukan pemesanan ulang.");
                        window.location.href = "{{ route('user.review') }}";
                    }
                }
                
                startTimer(); 
                let timerInterval = setInterval(startTimer, 1000);
            }

            // Logika Akordion Otomatis
            const accordions = document.querySelectorAll('.accordion-item');
            accordions.forEach(item => {
                item.addEventListener('toggle', function() {
                    if (this.open) {
                        accordions.forEach(otherItem => {
                            if (otherItem !== this) {
                                otherItem.removeAttribute('open');
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>