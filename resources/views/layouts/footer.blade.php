<style>
    /* =========================================
    EFEK HOVER PROFESIONAL FOOTER ROOMLY
       ========================================= */

    /* 1. Persiapan animasi agar transisinya mulus (smooth) */
    .footer a, .partner-box {
        transition: all 0.3s ease-in-out;
    }

    /* 2. Efek Hover untuk Teks Menu (Tentang Roomly, Lainnya) & Sosmed */
    .footer .list-unstyled li a {
        display: inline-block; /* Wajib agar efek geser berfungsi */
    }
    
    .footer .list-unstyled li a:hover {
        color: #FFD700 !important; /* Berubah jadi warna emas terang */
        transform: translateX(8px); /* Teks bergeser halus ke kanan */
        opacity: 1 !important; /* Menghilangkan efek transparan (opacity-75) */
    }

    /* Bikin icon sosmed (gambar SVG/PNG) juga ikut membesar sedikit saat teksnya di-hover */
    .footer .list-unstyled li a:hover img {
        transform: scale(1.15);
        transition: all 0.3s ease;
    }

    /* 3. Efek Hover untuk Kotak Partner Pembayaran */
    .partner-box:hover {
        transform: translateY(-5px); /* Kotak mengambang ke atas */
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.4); /* Muncul bayangan 3D di bawah kotak */
        border: 1px solid #FFD700; /* Muncul garis tepi tipis warna emas */
        cursor: pointer;
    }
</style>

<footer class="footer py-4" style="background-color: #8C5E23; color: #ffffff;">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="footer-logo mb-2">
                    <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="Roomly Logo" width="170">
                </div>
                
                <h5 class="fw-bold mb-3 text-white">Partner Pembayaran</h5>
                
                <div class="row g-2 align-items-center" style="max-width: 340px;">
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_bca.png') }}" alt="BCA">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_mandiri.png') }}" alt="Mandiri">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_bri.png') }}" alt="BRI">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_bni.png') }}" alt="BNI">
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/bank_cimb.svg') }}" alt="CIMB">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_atm_bersama.png') }}" alt="ATM Bersama">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_prima.png') }}" alt="Prima">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_alto.png') }}" alt="Alto">
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_link.png') }}" alt="LinkAja">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_visa.png') }}" alt="Visa">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_mastercard.png') }}" alt="Mastercard">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_jcb.png') }}" alt="JCB">
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_amex.png') }}" alt="Amex">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_alfamart.png') }}" alt="Alfamart">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_alfamidi.png') }}" alt="Alfamidi">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="partner-box">
                            <img src="{{ asset('assets/img/partners/logo_indomaret.png') }}" alt="Indomaret">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="mb-4">
                    <h5 class="fw-bold mb-3 text-white">Tentang Roomly</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('cara-pesan') }}" class="text-white text-decoration-none opacity-75">Cara Pesan</a></li>
                        <li class="mb-2"><a href="{{ route('hubungi-kami') }}" class="text-white text-decoration-none opacity-75">Hubungi Kami</a></li>
                        <li class="mb-2"><a href="{{ route('pusat-bantuan') }}" class="text-white text-decoration-none opacity-75">Pusat Bantuan</a></li>
                        <li class="mb-2"><a href="{{ route('tentang-kami') }}" class="text-white text-decoration-none opacity-75">Tentang Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="fw-bold mb-3 text-white">Follow kami di</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/logo_facebook.svg') }}" width="20" class="me-2" alt="Facebook"> Facebook
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/logo_instagram.svg') }}" width="20" class="me-2" alt="Instagram"> Instagram
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/logo_tiktok.svg') }}" width="20" class="me-2" alt="Tiktok"> Tiktok
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-white text-decoration-none d-flex align-items-center">
                                <img src="{{ asset('assets/img/icons/logo_whatsapp.svg') }}" width="20" class="me-2" alt="WhatsApp"> WhatsApp
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3 text-white">Lainnya</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('privasi') }}" class="text-white text-decoration-none opacity-75">Pemberitahuan Privasi</a></li>
                    <li class="mb-2"><a href="{{ route('syarat-ketentuan') }}" class="text-white text-decoration-none opacity-75">Syarat & Ketentuan</a></li>
                </ul>
            </div>

        </div>

        <div class="text-center mt-5 text-white-50 border-top pt-3" style="border-color: rgba(255,255,255,0.1) !important;">
            <p class="mb-0">&copy; 2026 Roomly. All Rights Reserved.</p>
        </div>
    </div>
</footer>