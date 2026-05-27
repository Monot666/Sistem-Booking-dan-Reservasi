@extends('layouts.app')

@section('content')
<link href="{{ asset('assets/css/privasi.css') }}" rel="stylesheet">

<div class="bg-white py-3 px-4 border-bottom">
    <a href="{{ route('landing') }}" class="text-decoration-none" style="color: #df9e45; font-size: 1.5rem;">
        <i class="fas fa-chevron-left"></i>
    </a>
</div>

<section class="content-privasi">
    <div class="container">
        <div class="document-container">
            
            <div class="text-center mb-5">
                <img src="{{ asset('assets/img/icons/logo.svg') }}" style="width: 140px;" class="mb-4" alt="Logo Roomly">
                <h1 class="document-title">Pemberitahuan Privasi Roomly</h1>
                <p class="last-updated">Terakhir diperbarui: 27 Mei 2026</p>
            </div>
            
            <div class="document-body text-start">
                <p>
                    Selamat datang di <strong>Roomly</strong>. Kami sangat menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda. Pemberitahuan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, mengelola, dan melindungi informasi Anda ketika Anda mengunjungi website kami dan menggunakan layanan reservasi kamar kami untuk <strong>Aston Hotel Solo</strong>.
                </p>

                <h4 class="fw-bold mt-4 mb-3">1. Informasi yang Kami Kumpulkan</h4>
                <p>Untuk memberikan layanan terbaik, kami mengumpulkan beberapa jenis informasi saat Anda melakukan reservasi atau berinteraksi dengan website kami, antara lain:</p>
                <ul class="ps-3 mb-4">
                    <li class="mb-2"><strong>Data Identitas:</strong> Nama lengkap, jenis kelamin, dan nomor identitas (KTP/Paspor).</li>
                    <li class="mb-2"><strong>Data Kontak:</strong> Alamat email, nomor telepon, dan alamat tempat tinggal.</li>
                    <li class="mb-2"><strong>Data Pembayaran:</strong> Rincian kartu kredit/debit atau metode pembayaran lainnya. <em>(Catatan: Rincian pembayaran diproses secara aman melalui gerbang pembayaran pihak ketiga yang terpercaya dan kami tidak menyimpan nomor kartu Anda)</em>.</li>
                    <li class="mb-2"><strong>Data Reservasi:</strong> Tanggal kedatangan dan keberangkatan, tipe kamar, serta permintaan khusus (seperti alergi makanan atau kebutuhan aksesibilitas).</li>
                    <li class="mb-2"><strong>Data Teknis:</strong> Alamat IP, jenis peramban (browser), sistem operasi, dan aktivitas penggunaan website saat Anda menjelajah (melalui Cookies).</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">2. Bagaimana Kami Menggunakan Data Anda</h4>
                <p>Kami menggunakan data pribadi Anda secara eksklusif untuk tujuan berikut:</p>
                <ul class="ps-3 mb-4">
                    <li class="mb-2">Memproses, memverifikasi, dan mengelola reservasi kamar Anda.</li>
                    <li class="mb-2">Mengirimkan konfirmasi pemesanan, faktur, dan pembaruan terkait masa menginap Anda.</li>
                    <li class="mb-2">Memproses transaksi pembayaran dan mencegah tindakan penipuan (fraud).</li>
                    <li class="mb-2">Memenuhi permintaan khusus tamu selama menginap.</li>
                    <li class="mb-2">Memperbaiki sistem, keamanan, dan tata letak website kami.</li>
                    <li class="mb-2">Mengirimkan penawaran promosi, diskon, atau buletin informasi (hanya jika Anda telah mendaftar/memberikan persetujuan untuk menerimanya).</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">3. Pembagian Data kepada Pihak Ketiga</h4>
                <p>Kami tidak akan menjual atau menyewakan data pribadi Anda kepada pihak mana pun. Kami hanya membagikan informasi Anda kepada pihak ketiga yang terpercaya dalam batasan berikut:</p>
                <ul class="ps-3 mb-4">
                    <li class="mb-2"><strong>Penyedia Layanan:</strong> Mitra gerbang pembayaran (payment gateway), penyedia layanan IT, atau layanan pengiriman email yang membantu operasional kami.</li>
                    <li class="mb-2"><strong>Kewajiban Hukum:</strong> Jika diwajibkan oleh hukum, pengadilan, atau otoritas pemerintah yang berwenang demi mematuhi proses hukum yang berlaku.</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">4. Keamanan Data Anda</h4>
                <p>Kami menerapkan standar keamanan teknis dan organisasi yang ketat, termasuk penggunaan teknologi enkripsi (seperti SSL/Secure Socket Layer), untuk memastikan transmisi data Anda aman dan terlindungi dari akses, penyalahgunaan, modifikasi, atau penghancuran yang tidak sah.</p>

                <h4 class="fw-bold mt-4 mb-3">5. Penyimpanan Data (Retensi)</h4>
                <p>Kami hanya akan menyimpan data pribadi Anda selama diperlukan untuk memenuhi tujuan yang dijelaskan dalam Pemberitahuan Privasi ini, atau selama diwajibkan oleh peraturan perpajakan dan hukum komersial di Indonesia.</p>

                <h4 class="fw-bold mt-4 mb-3">6. Hak-Hak Anda</h4>
                <p>Asal pemilik data, Anda memiliki hak untuk:</p>
                <ul class="ps-3 mb-4">
                    <li class="mb-2">Meminta akses atau salinan data pribadi Anda yang ada di sistem kami.</li>
                    <li class="mb-2">Meminta perbaikan jika terdapat data yang tidak akurat.</li>
                    <li class="mb-2">Meminta penghapusan data pribadi Anda (dengan pengecualian data yang harus kami simpan untuk keperluan hukum/pajak).</li>
                    <li class="mb-2">Menarik persetujuan Anda kapan saja terkait pengiriman pesan pemasaran/promosi dengan mengklik tautan <em>unsubscribe</em> pada email kami.</li>
                </ul>

                <h4 class="fw-bold mt-4 mb-3">7. Hubungi Kami</h4>
                <p>Jika Anda memiliki pertanyaan, kekhawatiran, atau ingin menggunakan hak Anda terkait data pribadi, silakan hubungi kami melalui:</p>
                <ul class="ps-3 mb-0" style="list-style-type: none;">
                    <li class="mb-2"><i class="fas fa-envelope text-muted me-2"></i> <strong>Email:</strong> roomlytrust@gmail.com</li>
                    <li class="mb-2"><i class="fas fa-phone text-muted me-2"></i> <strong>Telepon:</strong> +62 877 5931 5863</li>
                    <li class="mb-2"><i class="fas fa-map-marker-alt text-muted me-2"></i> <strong>Alamat Fisik:</strong> Jl. Slamet Riyadi No. 373, Surakarta, Jawa Tengah, Indonesia</li>
                </ul>
            </div>
            
        </div>
    </div>
</section>

@include('layouts.footer')

@endsection