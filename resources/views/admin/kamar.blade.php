<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Kamar - Roomly Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/kamar.css') }}">
</head>
<body>
<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="logo-area">
            <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="Logo">
            <div class="logo-text">
                <h4>Roomly Admin</h4>
                <small>Portal Manajemen</small>
            </div>
        </div>
        <ul class="nav-links">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-th-large"></i> Dasbor</a>
            </li>
            <li class="{{ request()->routeIs('admin.kamar') ? 'active' : '' }}">
                <a href="{{ route('admin.kamar') }}"><i class="fas fa-bed"></i> Kamar</a>
            </li>
            <li class="{{ request()->routeIs('admin.room_units') ? 'active' : '' }}">
                <a href="{{ route('admin.room_units') }}"><i class="fas fa-door-open"></i> Unit Kamar</a>
            </li>
            <li class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                <a href="{{ route('admin.bookings') }}"><i class="fas fa-calendar-alt"></i> Pesanan</a>
            </li>
            <li class="{{ request()->routeIs('admin.guests') ? 'active' : '' }}">
                <a href="{{ route('admin.guests') }}"><i class="fas fa-users"></i> Tamu</a>
            </li>
            <li class="{{ request()->routeIs('admin.finance') ? 'active' : '' }}">
                <a href="{{ route('admin.finance') }}"><i class="fas fa-wallet"></i> Keuangan</a>
            </li>
            
            <li class="nav-logout" style="margin-top: auto;">
                <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" style="display: block;">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content">
        
        <div class="hotel-header">
            <div class="d-flex align-items-center">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=200" alt="Hotel" class="hotel-img">
                <div class="ms-4">
                    <h3 class="text-white mb-1 fw-bold">Aston Solo Hotel</h3>
                    <p class="mb-1" style="color: #94a3b8;"><i class="fas fa-map-marker-alt me-2"></i>Solo</p>
                    <small style="color: #64748b;">Strategic hotel in the heart of Solo</small>
                </div>
            </div>
            <button type="button" class="btn btn-add-room" data-bs-toggle="modal" data-bs-target="#addRoomModal">
                + Add Room
            </button>
        </div>

        <div class="row g-4">
            @foreach($rooms as $room)
            <div class="col-md-4">
                <div class="room-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="room-title">{{ $room->name }}</h5>
                            <span class="room-type">{{ $room->type }}</span>
                        </div>
                        <span class="badge-tersedia">Tersedia</span>
                    </div>
                    
                    <div class="price-box">
                        <span class="price-label">Harga</span> 
                        <span class="price-value">Rp. {{ number_format($room->price_per_hour, 0, ',', '.') }}</span>
                    </div>
                    
                    <ul class="info-list">
                        <li><i class="fas fa-user"></i> Kapasitas: {{ $room->capacity }} Tamu</li>
                        <li><i class="fas fa-layer-group"></i> Lantai: 1</li>
                    </ul>

                    <div class="amenities-badges mb-4">
                        <div class="text-muted mb-2" style="font-size: 0.75rem;">Fasilitas:</div>
                        @if($room->facilities)
                            @foreach(explode(',', $room->facilities) as $facility)
                                <span>{{ trim($facility) }}</span>
                            @endforeach
                        @else
                            <span class="text-muted fst-italic">Belum ada fasilitas</span>
                        @endif
                    </div>
                    
                    <div class="action-buttons">
                        <button type="button" class="btn-edit" data-bs-toggle="modal" data-bs-target="#editRoomModal{{ $room->id }}">
                            <i class="fas fa-edit me-1"></i> Edit
                        </button>
                        <button type="button" class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteRoomModal{{ $room->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editRoomModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content custom-modal">
                        <div class="modal-header border-0 pb-0 pt-4 px-4">
                            <h4 class="modal-title fw-bold">Edit Room</h4>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Room Number / Name</label>
                                    <input type="text" class="form-control custom-input" name="name" value="{{ $room->name }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Room Type</label>
                                    <select class="form-select custom-input" name="type" required>
                                        <option value="Deluxe" {{ $room->type == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                                        <option value="Superior Double" {{ $room->type == 'Superior Double' ? 'selected' : '' }}>Superior Double</option>
                                        <option value="Executive Suite" {{ $room->type == 'Executive Suite' ? 'selected' : '' }}>Executive Suite</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Price per Night (Rp)</label>
                                    <input type="number" class="form-control custom-input" name="price_per_hour" value="{{ $room->price_per_hour }}" required>
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label class="form-label fw-bold">Capacity</label>
                                        <input type="number" class="form-control custom-input" name="capacity" value="{{ $room->capacity }}" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold">Floor</label>
                                        <input type="number" class="form-control custom-input" value="1">
                                    </div>
                                </div>
                                
                                @php
                                    $room_facs = array_map('trim', explode(',', $room->facilities));
                                @endphp
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-2">Amenities</label>
                                    <div class="row g-2" style="font-size: 0.9rem;">
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="🚿 Shower" id="edit_shower_{{ $room->id }}" {{ in_array('🚿 Shower', $room_facs) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit_shower_{{ $room->id }}">🚿 Shower</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="❄️ AC" id="edit_ac_{{ $room->id }}" {{ in_array('❄️ AC', $room_facs) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit_ac_{{ $room->id }}">❄️ AC</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="📶 WiFi" id="edit_wifi_{{ $room->id }}" {{ in_array('📶 WiFi', $room_facs) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit_wifi_{{ $room->id }}">📶 WiFi</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="📺 Smart TV" id="edit_tv_{{ $room->id }}" {{ in_array('📺 Smart TV', $room_facs) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit_tv_{{ $room->id }}">📺 Smart TV</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="🔲 Mini Fridge" id="edit_fridge_{{ $room->id }}" {{ in_array('🔲 Mini Fridge', $room_facs) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit_fridge_{{ $room->id }}">🔲 Mini Fridge</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="☕ Coffee Maker" id="edit_coffee_{{ $room->id }}" {{ in_array('☕ Coffee Maker', $room_facs) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit_coffee_{{ $room->id }}">☕ Coffee Maker</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="🔐 Safe Deposit Box" id="edit_safe_{{ $room->id }}" {{ in_array('🔐 Safe Deposit Box', $room_facs) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit_safe_{{ $room->id }}">🔐 Safe Deposit Box</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="💨 Hairdryer" id="edit_hairdryer_{{ $room->id }}" {{ in_array('💨 Hairdryer', $room_facs) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit_hairdryer_{{ $room->id }}">💨 Hairdryer</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="🛁 Bathtub" id="edit_bathtub_{{ $room->id }}" {{ in_array('🛁 Bathtub', $room_facs) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="edit_bathtub_{{ $room->id }}">🛁 Bathtub</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-submit-full w-100">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteRoomModal{{ $room->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content custom-modal p-4 text-center">
                        <i class="fas fa-exclamation-circle text-danger mb-3" style="font-size: 3.5rem;"></i>
                        <h4 class="fw-bold mb-2">Hapus Kamar?</h4>
                        <p class="text-muted mb-4">Apakah Anda yakin ingin menghapus <b>{{ $room->name }}</b>? Data kamar yang dihapus tidak dapat dikembalikan.</p>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 8px;">Ya, Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content custom-modal">
                    
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <h4 class="modal-title fw-bold" id="addRoomModalLabel">Add New Room</h4>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body p-4">
                        <form action="{{ route('admin.rooms.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Room Number / Name</label>
                                <input type="text" class="form-control custom-input" name="name" placeholder="e.g. 101 or Superior 1" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Room Type</label>
                                <select class="form-select custom-input" name="type" required>
                                    <option value="Deluxe">Deluxe</option>
                                    <option value="Superior Double">Superior Double</option>
                                    <option value="Executive Suite">Executive Suite</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Price per Night (Rp)</label>
                                <input type="number" class="form-control custom-input" name="price_per_hour" placeholder="500000" required>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label class="form-label fw-bold">Capacity</label>
                                    <input type="number" class="form-control custom-input" name="capacity" placeholder="2" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-bold">Floor</label>
                                    <input type="number" class="form-control custom-input" placeholder="1">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-2">Amenities</label>
                                <div class="row g-2" style="font-size: 0.9rem;">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="🚿 Shower" id="add_shower">
                                            <label class="form-check-label" for="add_shower">🚿 Shower</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="❄️ AC" id="add_ac">
                                            <label class="form-check-label" for="add_ac">❄️ AC</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="📶 WiFi" id="add_wifi">
                                            <label class="form-check-label" for="add_wifi">📶 WiFi</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="📺 Smart TV" id="add_tv">
                                            <label class="form-check-label" for="add_tv">📺 Smart TV</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="🔲 Mini Fridge" id="add_fridge">
                                            <label class="form-check-label" for="add_fridge">🔲 Mini Fridge</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="☕ Coffee Maker" id="add_coffee">
                                            <label class="form-check-label" for="add_coffee">☕ Coffee Maker</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="🔐 Safe Deposit Box" id="add_safe">
                                            <label class="form-check-label" for="add_safe">🔐 Safe Deposit Box</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="💨 Hairdryer" id="add_hairdryer">
                                            <label class="form-check-label" for="add_hairdryer">💨 Hairdryer</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" name="facilities[]" value="🛁 Bathtub" id="add_bathtub">
                                            <label class="form-check-label" for="add_bathtub">🛁 Bathtub</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-submit-full w-100">Add Room</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </main>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal p-4 text-center">
            
            <div class="mb-3">
                <i class="fas fa-sign-out-alt text-danger" style="font-size: 3.5rem;"></i>
            </div>
            
            <h4 class="fw-bold mb-2">Konfirmasi Keluar</h4>
            <p class="text-muted mb-4">Apakah Anda yakin ingin keluar dari portal Admin Roomly? Sesi Anda akan diakhiri.</p>
            
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 8px; border: 1px solid #e2e8f0;">Batal</button>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 8px;">Ya, Keluar</button>
                </form>
            </div>
            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>