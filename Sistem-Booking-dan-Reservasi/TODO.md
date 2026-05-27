# TODO - Rapihkan Struktur & Sambungkan Semua

## Step 1 ✅
Edit `app/Http/Controllers/ResourceController.php`:
- `index()` render ke `resources/views/user/component/index.blade.php`.
- `show()` render ke `resources/views/user/component/show.blade.php`.


## Step 2 ✅
Edit `routes/web.php` (opsional/minor):
- rapikan route `/booking` public supaya mengarah ke view yang ada (`resources/views/user/booking.blade.php`) jika perlu.


## Step 3
Cek view yang dituju:
- Pastikan `resources/views/user/component/index.blade.php` memakai variabel `$resources`, `$checkin`, `$checkout`, `$guests`, `$rooms`.
- Pastikan `resources/views/user/component/show.blade.php` memakai `$resource`.

## Step 4
Verifikasi routing via CLI:
- Jalankan `php artisan route:list` untuk memastikan `resources.index` dan `resources.show` aktif.

## Step 5 ✅
Smoke test manual:
- buka `/booking` (search)
- pilih resource menuju `resources.show`


