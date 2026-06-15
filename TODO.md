# TODO - Backend Refactoring Tracker

## Completed ✅
- [x] Reorganized controller namespace structure (Auth/, User/, Admin/, _Deprecated/)
- [x] Renamed `Resource` model → `Room` (table remains `resources`)
- [x] Consolidated `BookingController` + `PemesananController` + `PembayaranController` → `User\BookingController`
- [x] Standardized all route names and URL paths to English
- [x] Removed duplicate routes (`/component`, `/user/booking`)
- [x] Updated all Blade view `route()` references to match new route names
- [x] Added proper `$casts`, docblocks, and validation to all models
- [x] Moved deprecated controllers to `_Deprecated/` folder
- [x] Renamed factory and seeder (`ResourceFactory` → `RoomFactory`, `ResourceSeeder` → `RoomSeeder`)

## Pending
- [x] Run `php artisan route:list` to verify all routes
- [x] Smoke test manual flow:
  1. Open `/bookings` (search)
  2. Select room → `/rooms`
  3. Review → `/bookings/review`
  4. Submit → redirect to `/bookings/{id}/payment`
- [x] Clean up remaining `Resource.php` model file if still present
- [x] Delete old `name('booking')` file in project root (seems accidental)
