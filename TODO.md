- [x] Pahami flow route: pilih kamar -> review-pemesanan -> store -> pembayaran
- [x] Samakan controller yang dipakai flow pemesanan menggunakan `App\Http\Controllers\user\PemesananController`
- [x] Edit `routes/web.php` agar route review & store mengarah ke `PemesananController`
- [x] Rapikan validasi `PemesananController@store` supaya field sesuai form (termasuk `request[]`)
- [x] Hapus/abaikan controller duplikat `ReviewPemesanan.php` dari route penggunaan (file didepresiasi)
- [ ] Jalankan `php artisan migrate` (jika perlu) dan uji manual flow:
  1) buka `/pilih-kamar`
  2) pilih kamar -> `/user/review-pemesanan`
  3) submit -> redirect ke `/user/pembayaran/{id}`

