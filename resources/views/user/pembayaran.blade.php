<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Roomly</title>
    <!-- Google Fonts & FontAwesome CDN -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/pembayaran.css') }}?v={{ time() }}">
</head>
<body>

<!-- NAVBAR ATAS -->
<div class="page-header">
    <a href="{{ route('bookings.review') }}" class="back-arrow">&#10094;</a>
    <h1>Pembayaran</h1>
</div>

<div class="container">
    
    <!-- KOLOM KIRI: FORM PILIHAN METODE & RINCIAN HARGA -->
    <div class="main-content">
        
        <!-- ALERT TIMER COUNTDOWN -->
        <div class="timer-alert">
            <span>Tenang, harganya tidak akan berubah. Yuk selesaikan pembayaran dalam</span>
            <span class="timer-count" id="countdown-timer" data-redirect="{{ route('bookings.review') }}">00:15:20</span>
        </div>

        <form action="#" method="POST">
            @csrf

            <!-- GRUP METODE PEMBAYARAN BER-ACCORDION LENGKAP -->
            <div class="card">
                <h3 class="card-title">Mau bayar pakai metode apa?</h3>
                
                <div class="payment-list-group">
                    
                    <!-- METODE 1: VIRTUAL ACCOUNT (Terbuka Secara Bawaan) -->
                    <div class="payment-group-item active">
                        <div class="payment-header-trigger">
                            <div class="row-left">
                                <input type="radio" name="payment_method" value="VA" class="parent-radio" checked>
                                <label>Virtual Account</label>
                            </div>
                        </div>
                        <div class="payment-dropdown-content" style="display: block;">
                            <div class="va-sub-container">
                                <div class="va-sub-row">
                                    <div class="sub-left">
                                        <input type="radio" name="va_bank_selected" value="BCA" checked>
                                        <span>BCA Virtual Account</span>
                                    </div>
                                    <img src="{{ asset('assets/img/partners/bank_bca.png') }}" alt="BCA" class="va-bank-logo">
                                </div>
                                <div class="va-sub-row">
                                    <div class="sub-left">
                                        <input type="radio" name="va_bank_selected" value="MANDIRI">
                                        <span>Mandiri Virtual Account</span>
                                    </div>
                                    <img src="{{ asset('assets/img/partners/bank_mandiri.png') }}" alt="Mandiri" class="va-bank-logo">
                                </div>
                                <div class="va-sub-row">
                                    <div class="sub-left">
                                        <input type="radio" name="va_bank_selected" value="BRI">
                                        <span>BRI Virtual Account</span>
                                    </div>
                                    <img src="{{ asset('assets/img/partners/bank_bri.png') }}" alt="BRI" class="va-bank-logo">
                                </div>
                                <div class="va-sub-row">
                                    <div class="sub-left">
                                        <input type="radio" name="va_bank_selected" value="BNI">
                                        <span>BNI Virtual Account</span>
                                    </div>
                                    <img src="{{ asset('assets/img/partners/bank_bni.png') }}" alt="BNI" class="va-bank-logo">
                                </div>
                                <div class="va-sub-row">
                                    <div class="sub-left">
                                        <input type="radio" name="va_bank_selected" value="CIMB">
                                        <span>CIMB Niaga Virtual Account</span>
                                    </div>
                                    <img src="{{ asset('assets/img/partners/bank_cimb.svg') }}" alt="CIMB" class="va-bank-logo">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- METODE 2: TRANSFER DARI SEMUA BANK (MANUAL) -->
                    <div class="payment-group-item">
                        <div class="payment-header-trigger">
                            <div class="row-left">
                                <input type="radio" name="payment_method" value="TRANSFER" class="parent-radio">
                                <label>Transfer dari semua bank</label>
                            </div>
                            <div class="row-right"><i class="fa-solid fa-building-columns bank-right-icon"></i></div>
                        </div>
                        <div class="payment-dropdown-content">
                            <div class="transfer-info-block">
                                <label>Transfer ke rekening resmi Roomly:</label>
                                <div class="copy-field-wrapper">
                                    <input type="text" id="rekening-number" value="1234567890987" readonly>
                                    <button type="button" class="btn-copy-rekening" onclick="copyAccountNumber()">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                </div>
                                <span class="input-desc-alt">Bank Mandiri a.n PT Roomly Global Indonesia</span>
                            </div>
                        </div>
                    </div>

                    <!-- METODE 3: ATM -->
                    <div class="payment-group-item">
                        <div class="payment-header-trigger">
                            <div class="row-left">
                                <input type="radio" name="payment_method" value="ATM" class="parent-radio">
                                <label>ATM</label>
                            </div>
                            <div class="row-right logos-flex">
                                <img src="{{ asset('assets/img/partners/logo_atm_bersama.png') }}" alt="ATM Bersama" class="method-header-logo">
                                <img src="{{ asset('assets/img/partners/logo_prima.png') }}" alt="Prima" class="method-header-logo">
                                <img src="{{ asset('assets/img/partners/logo_alto.png') }}" alt="Alto" class="method-header-logo">
                                <img src="{{ asset('assets/img/partners/logo_link.png') }}" alt="Link" class="method-header-logo">
                            </div>
                        </div>
                        <div class="payment-dropdown-content">
                            <div class="transfer-info-block">
                                <label style="font-weight: 600; margin-bottom: 5px;">Panduan Transfer ATM:</label>
                                <ol style="margin: 0; padding-left: 20px; font-size: 0.82rem; color: #64748b; line-height: 1.6;">
                                    <li>Masukkan kartu ATM dan PIN Anda.</li>
                                    <li>Pilih menu <strong>Transfer > Ke Rekening Bank Lain</strong>.</li>
                                    <li>Masukkan kode bank penampung resmi Roomly yang akan terbit di invoice.</li>
                                    <li>Simpan resi ATM sebagai bukti pembayaran sah.</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- METODE 4: KARTU KREDIT/DEBIT -->
                    <div class="payment-group-item">
                        <div class="payment-header-trigger">
                            <div class="row-left">
                                <input type="radio" name="payment_method" value="CC" class="parent-radio">
                                <label>Kartu Kredit/Debit</label>
                            </div>
                            <div class="row-right logos-flex">
                                <img src="{{ asset('assets/img/partners/logo_visa.png') }}" alt="Visa" class="method-header-logo">
                                <img src="{{ asset('assets/img/partners/logo_mastercard.png') }}" alt="Mastercard" class="method-header-logo">
                                <img src="{{ asset('assets/img/partners/logo_jcb.png') }}" alt="JCB" class="method-header-logo">
                                <img src="{{ asset('assets/img/partners/logo_amex.png') }}" alt="Amex" class="method-header-logo">
                            </div>
                        </div>
                        <div class="payment-dropdown-content">
                            <div class="cc-form-container">
                                <div class="cc-field">
                                    <input type="text" name="cc_number" class="form-control-cc" placeholder="Nomor Kartu (16 Digit)" maxlength="16">
                                </div>
                                <div class="cc-field-row">
                                    <input type="text" name="cc_expiry" class="form-control-cc" placeholder="MM/YY" maxlength="5">
                                    <input type="password" name="cc_cvv" class="form-control-cc" placeholder="CVV" maxlength="3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- METODE 5: MINIMARKET -->
                    <div class="payment-group-item">
                        <div class="payment-header-trigger">
                            <div class="row-left">
                                <input type="radio" name="payment_method" value="MINIMARKET" class="parent-radio">
                                <label>Minimarket</label>
                            </div>
                            <div class="row-right logos-flex">
                                <img src="{{ asset('assets/img/partners/logo_alfamart.png') }}" alt="Alfamart" class="method-header-logo">
                                <img src="{{ asset('assets/img/partners/logo_alfamidi.png') }}" alt="Alfamidi" class="method-header-logo">
                                <img src="{{ asset('assets/img/partners/logo_indomaret.png') }}" alt="Indomaret" class="method-header-logo">
                            </div>
                        </div>
                        <div class="payment-dropdown-content">
                            <div class="va-sub-container">
                                <div class="va-sub-row">
                                    <div class="sub-left">
                                        <input type="radio" name="mart_selected" value="ALFAMART" checked>
                                        <span>Alfamart / Alfamidi</span>
                                    </div>
                                </div>
                                <div class="va-sub-row">
                                    <div class="sub-left">
                                        <input type="radio" name="mart_selected" value="INDOMARET">
                                        <span>Indomaret</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- KARTU KUPON -->
            <div class="card coupon-card-layout">
                <div class="coupon-left">
                    <span class="coupon-icon-tag">🎟️</span>
                    <div class="coupon-text-block">
                        <h4>Pakai Kupon</h4>
                        <p>Masukkan kode kupon (jika ada)</p>
                    </div>
                </div>
                <a href="javascript:void(0)" class="coupon-action-trigger">Pakai</a>
            </div>

            <!-- KARTU RINCIAN HARGA -->
            <div class="card price-summary-card">
                <h3 class="summary-section-title">Rincian Harga</h3>
                
                <div class="price-data-line">
                    <span class="label-text">Aston Solo Hotel, {{ $pemesanan->room_name }} - {{ $pemesanan->option_type }} (1x)</span>
                    <span class="value-text">Rp. {{ number_format($pemesanan->price_per_night, 0, ',', '.') }}</span>
                </div>
                <div class="price-data-line">
                    <span class="label-text">Pajak dan Biaya</span>
                    <span class="value-text">Rp. {{ number_format($pemesanan->tax_and_fee, 0, ',', '.') }}</span>
                </div>
                <div class="price-data-line coupon-discount-line">
                    <span class="label-text">Kupon</span>
                    <span class="value-text">-Rp. 50.000</span>
                </div>

                <div class="divider-line-th"></div>

                <div class="price-data-line total-price-final-row">
                    <span class="total-label">Harga Total</span>
                    <span class="total-value">Rp. {{ number_format($pemesanan->total_price - 50000, 0, ',', '.') }}</span>
                </div>

                <!-- FAIL-SAFE BUTTON: Memicu fungsi redirect client-side aman -->
                <button type="button" onclick="executePaymentRedirect()" class="btn-execute-payment">Bayar</button>
                
                <p class="payment-legal-notice">
                    Dengan melanjutkan, Kamu menyetujui Syarat &amp; Ketentuan kami serta memahami bahwa detail pesananmu dapat dibagikan dan diproses oleh mitra terpercaya kami, seperti yang tertera di pemberitahuan privasi.
                </p>
            </div>
        </form>

    </div>

    <!-- KOLOM KANAN: REKAP SIDEBAR -->
    <div class="sidebar-sticky">
        <div class="card sidebar-hotel-card">
            <div class="hotel-orange-top-header">
                <div class="header-left-title">
                    <i class="fa-solid fa-hotel building-icon"></i>
                    <div class="text-h">
                        <h3>Rincian Hotel</h3>
                        <p>No. Pesanan {{ $pemesanan->no_pesanan }}</p>
                    </div>
                </div>
            </div>

            <div class="sidebar-card-body">
                <h2 class="hotel-main-name">Aston Hotel Solo</h2>
                <h4 class="room-sub-detail">(1x) {{ $pemesanan->room_name }} - {{ $pemesanan->option_type }}</h4>
                
                <div class="timeline-horizontal-box">
                    <div class="t-node">
                        <span class="t-label">Check-in</span>
                        <strong class="t-date">Kamis, 12 Maret 2026</strong>
                        <span class="t-sub">Dari 14:00</span>
                    </div>
                    <div class="t-arrow-center"><i class="fa-solid fa-arrow-right"></i></div>
                    <div class="t-node text-right">
                        <span class="t-label">Check-out</span>
                        <strong class="t-date">Jumat, 13 Maret 2026</strong>
                        <span class="t-sub">Sebelum 12:00</span>
                    </div>
                </div>

                <div class="info-meta-vertical-list">
                    <div class="meta-item-row"><i class="fa-solid fa-users"></i> 2 Tamu &nbsp;|&nbsp; <i class="fa-solid fa-bed"></i> &nbsp;|&nbsp; <i class="fa-solid fa-wifi"></i></div>
                    <div class="meta-item-row text-danger-style"><i class="fa-solid fa-calendar-xmark"></i> Pemesanan ini tidak bisa di-refund.</div>
                    <div class="meta-item-row text-muted-style"><i class="fa-solid fa-ban"></i> Non-reschedulable</div>
                </div>

                <div class="divider-inside-sidebar"></div>

                <div class="guest-specs-summary">
                    <div class="spec-block">
                        <strong>Permintaan khusus (jika ada)</strong>
                        <p>{{ $pemesanan->permintaan_khusus ?? '-' }}</p>
                    </div>
                    <div class="spec-block">
                        <strong>Nama Tamu</strong>
                        <p>{{ $pemesanan->nama_pengunjung ?? 'Dimas Sudarmono' }}</p>
                    </div>
                </div>

                <div class="divider-inside-sidebar"></div>

                <div class="buyer-profile-section">
                    <h5 class="sect-heading">Data Pemesan</h5>
                    <div class="buyer-info-flex">
                        <div class="avatar-circle-icon"><i class="fa-regular fa-user"></i></div>
                        <div class="buyer-text">
                            <h4>{{ $pemesanan->nama_pemesan ?? 'Dimas Sudarmono' }}</h4>
                            <p>{{ $pemesanan->no_hp ?? '087759315863' }}</p>
                            <p class="email-subtext">{{ $pemesanan->email ?? 'monotxploit@gmail.com' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="banner-container single-wide-ad-box">
            <img src="{{ asset('assets/img/bg login.png') }}" alt="Teh Botol Sosro Landscape Banner">
        </div>
    </div>

</div>

<!-- MEMANGGIL FILE JAVASCRIPT ACCORDION & TIMING -->
<script src="{{ asset('assets/js/pembayaran.js') }}?v={{ time() }}"></script>

<!-- RE-ROUTING ACTION INTEGRATOR SCRIPT -->
<script>
    function executePaymentRedirect() {
        const selectedMethodElement = document.querySelector('input[name="payment_method"]:checked');
        
        if (!selectedMethodElement) {
            alert("Silakan pilih metode pembayaran terlebih dahulu.");
            return;
        }

        const selectedMethod = selectedMethodElement.value;
        
        // Diarahkan ke rute instruksi-pembayaran terlebih dahulu dengan prefix /user
        let targetUrl = '/user/instruksi-pembayaran?method=' + selectedMethod;

        if (selectedMethod === 'VA') {
            const selectedBankElement = document.querySelector('input[name="va_bank_selected"]:checked');
            const bankName = selectedBankElement ? selectedBankElement.value : 'BCA';
            targetUrl += '&bank=' + bankName;
        } else if (selectedMethod === 'MINIMARKET') {
            const selectedMartElement = document.querySelector('input[name="mart_selected"]:checked');
            const martName = selectedMartElement ? selectedMartElement.value : 'ALFAMART';
            targetUrl += '&mart=' + martName;
        }

        window.location.href = targetUrl;
    }
</script>

</body>
</html>