@extends('layouts.app')

@section('content')
<link href="{{ asset('assets/css/syarat-ketentuan.css') }}" rel="stylesheet">

<!-- Navigasi Atas -->
<div class="bg-white py-3 px-4 border-bottom">
    <a href="{{ route('home') }}" class="text-decoration-none" style="color: #df9e45; font-size: 1.5rem;">
        <i class="fas fa-chevron-left"></i>
    </a>
</div>

<!-- Konten Dokumen Syarat & Ketentuan -->
<section class="content-syarat">
    <div class="container">
        <div class="document-container">
            
            <!-- Header Dokumen -->
            <div class="text-center mb-5">
                <img src="{{ asset('assets/img/icons/logo.svg') }}" style="width: 140px;" class="mb-4" alt="Logo Roomly">
                <h1 class="document-title">Syarat dan Ketentuan Roomly</h1>
                <p class="last-updated">Terakhir diperbarui: 27 Mei 2026</p>
            </div>
            
            <!-- Isi Dokumen -->
            <div class="document-body text-start">
                <p>
                    Selamat datang di <strong>Roomly</strong>. Dengan mengakses, menelusuri, atau melakukan reservasi melalui website kami, Anda mengakui dan menyetujui bahwa Anda telah membaca, memahami, dan menyetujui Syarat dan Ketentuan yang tertulis di bawah ini. Jika Anda tidak menyetujui syarat-syarat ini, harap untuk tidak menggunakan layanan kami.
                </p>

                <h4 class="fw-bold mt-4 mb-3">1. Definisi dan Layanan</h4>
                <ul class="ps-3 mb-4">
                    <li class="mb-2"><strong>Platform:</strong> Mengacu pada website Roomly yang menyediakan fasilitas pemesanan kamar hotel secara online.</li>
                    <li class="mb-2"><strong>Layanan:</strong> Segala bentuk fasilitas reservasi, pembayaran, dan informasi ketersediaan kamar yang kami sediakan melalui platform ini.</li>
                    <li class="mb-2"><strong>Tamu/Anda:</strong> Setiap individu atau entitas yang menggunakan website Roomly untuk melakukan pemesanan.</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">2. Proses Pemesanan</h4>
                <ul class="ps-3 mb-4">
                    <li class="mb-2">Semua pemesanan yang dilakukan melalui Roomly bergantung pada ketersediaan kamar.</li>
                    <li class="mb-2">Anda wajib memberikan informasi yang akurat, lengkap, dan sah pada saat melakukan pemesanan (termasuk nama yang sesuai dengan kartu identitas resmi, email, dan detail kontak).</li>
                    <li class="mb-2">Pemesanan dianggap sah dan berstatus <em>Confirmed</em> (Terkonfirmasi) hanya setelah Roomly menerima pembayaran dan kami telah mengirimkan email konfirmasi yang berisi Nomor Reservasi (Booking ID).</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">3. Harga dan Pembayaran</h4>
                <ul class="ps-3 mb-4">
                    <li class="mb-2">Semua harga yang ditampilkan di Roomly sudah termasuk Pajak dan Biaya Pelayanan (Tax & Service), kecuali dinyatakan lain secara tertulis pada halaman pemesanan.</li>
                    <li class="mb-2">Pembayaran harus dilakukan secara penuh atau sesuai dengan metode cicilan/pembayaran sebagian yang tersedia di halaman pembayaran sebelum batas waktu (time limit) habis. Jika pembayaran tidak diterima, reservasi akan dibatalkan secara otomatis oleh sistem.</li>
                    <li class="mb-2">Mata uang yang digunakan dalam semua transaksi adalah Rupiah (IDR).</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">4. Kebijakan Pembatalan, Perubahan, dan Pengembalian Dana (Refund)</h4>
                <ul class="ps-3 mb-4">
                    <li class="mb-2"><strong>Kebijakan Pembatalan:</strong> Syarat pembatalan bervariasi bergantung pada tipe kamar atau promo yang dipilih. Beberapa kamar promo mungkin bersifat <em>Non-Refundable</em> (tidak dapat diuangkan kembali).</li>
                    <li class="mb-2"><strong>Pengembalian Dana:</strong> Jika tipe reservasi Anda memungkinkan pembatalan, permintaan refund harus diajukan selambat-lambatnya 48 jam sebelum waktu check-in. Dana akan dikembalikan melalui metode pembayaran awal dalam waktu 7-14 hari kerja.</li>
                    <li class="mb-2"><strong>Ketidakhadiran (No-Show):</strong> Jika Tamu tidak datang pada tanggal check-in yang telah dikonfirmasi tanpa pemberitahuan sebelumnya, maka reservasi dianggap batal dan total biaya menginap hangus (tidak ada pengembalian dana).</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">5. Waktu Check-in dan Check-out</h4>
                <ul class="ps-3 mb-4">
                    <li class="mb-2"><strong>Check-in:</strong> Mulai pukul 14:00 waktu setempat.</li>
                    <li class="mb-2"><strong>Check-out:</strong> Maksimal pukul 12:00 waktu setempat.</li>
                    <li class="mb-2">Permintaan untuk <em>Early Check-in</em> atau <em>Late Check-out</em> sangat bergantung pada ketersediaan kamar dan mungkin dikenakan biaya tambahan. Tamu wajib menunjukkan kartu identitas (KTP/Paspor) yang masih berlaku pada saat check-in.</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">6. Hak dan Kewajiban Tamu</h4>
                <ul class="ps-3 mb-4">
                    <li class="mb-2">Tamu bertanggung jawab atas segala kerusakan fasilitas kamar atau area hotel yang disebabkan oleh kelalaian atau kesengajaan Tamu selama menginap. Biaya perbaikan atau penggantian akan dibebankan kepada Tamu.</li>
                    <li class="mb-2">Hewan peliharaan tidak diizinkan di dalam area properti hotel.</li>
                    <li class="mb-2">Dilarang keras melakukan kegiatan ilegal, membawa senjata tajam, narkotika, atau barang berbahaya lainnya di dalam area penginapan.</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">7. Batasan Tanggung Jawab</h4>
                <ul class="ps-3 mb-4">
                    <li class="mb-2">Roomly selalu berupaya memastikan bahwa semua informasi, harga, dan gambar di website adalah akurat. Namun, kami tidak bertanggung jawab atas kesalahan ketik (tipografi) atau gangguan sistem teknis (server down) yang berada di luar kendali kami.</li>
                    <li class="mb-2">Roomly tidak bertanggung jawab atas kerugian, cedera, atau kerusakan barang bawaan Tamu yang terjadi selama masa menginap, kecuali terbukti diakibatkan oleh kelalaian berat dari pihak manajemen.</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">8. Hukum yang Berlaku</h4>
                <p>
                    Syarat dan Ketentuan ini diatur dan ditafsirkan berdasarkan hukum yang berlaku di Republik Indonesia. Segala perselisihan yang timbul sehubungan dengan layanan ini akan diselesaikan secara musyawarah, atau melalui yurisdiksi pengadilan negeri Surakarta.
                </p>

                <h4 class="fw-bold mt-4 mb-3">9. Kontak dan Layanan Pelanggan</h4>
                <p>Jika Anda membutuhkan bantuan terkait pemesanan atau memiliki pertanyaan tentang Syarat dan Ketentuan ini, silakan hubungi tim kami di:</p>
                <ul class="ps-3 mb-0" style="list-style-type: none;">
                    <li class="mb-2"><i class="fas fa-envelope text-muted me-2"></i> <strong>Email:</strong> roomlytrust@gmail.com</li>
                    <li class="mb-2"><i class="fas fa-phone text-muted me-2"></i> <strong>WhatsApp / Telepon:</strong> +62 877 5931 5863</li>
                </ul>
            </div>
            
        </div>
    </div>
</section>

<!-- Footer Global -->
@include('layouts.footer')

@endsection