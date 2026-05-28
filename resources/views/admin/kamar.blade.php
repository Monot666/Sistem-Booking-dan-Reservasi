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
            <li class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                <a href="{{ route('admin.bookings') }}"><i class="fas fa-calendar-alt"></i> Pesanan</a>
            </li>
            <li><a href="#"><i class="fas fa-users"></i> Tamu</a></li>
            <li><a href="#"><i class="fas fa-wallet"></i> Keuangan</a></li>
            <li class="nav-logout"><a href="#"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
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
                        <span>Wi-Fi</span>
                        <span>TV</span>
                        <span>Mini Bar</span>
                        <span>City View</span>
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
                            <form action="#" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Room Number / Name</label>
                                    <input type="text" class="form-control custom-input" name="name" value="{{ $room->name }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Room Type</label>
                                    <select class="form-select custom-input" name="type">
                                        <option value="Deluxe" {{ $room->type == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                                        <option value="Superior Double" {{ $room->type == 'Superior Double' ? 'selected' : '' }}>Superior Double</option>
                                        <option value="Executive Suite" {{ $room->type == 'Executive Suite' ? 'selected' : '' }}>Executive Suite</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Price per Night (Rp)</label>
                                    <input type="number" class="form-control custom-input" name="price_per_hour" value="{{ $room->price_per_hour }}">
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label class="form-label fw-bold">Capacity</label>
                                        <input type="number" class="form-control custom-input" name="capacity" value="{{ $room->capacity }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold">Floor</label>
                                        <input type="number" class="form-control custom-input" value="1">
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold mb-2">Amenities</label>
                                    <div class="row g-2" style="font-size: 0.9rem;">
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" id="edit_wifi_{{ $room->id }}">
                                                <label class="form-check-label" for="edit_wifi_{{ $room->id }}">Wi-Fi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" id="edit_tv_{{ $room->id }}">
                                                <label class="form-check-label" for="edit_tv_{{ $room->id }}">TV</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" id="edit_minibar_{{ $room->id }}">
                                                <label class="form-check-label" for="edit_minibar_{{ $room->id }}">Mini Bar</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" id="edit_smoking_{{ $room->id }}">
                                                <label class="form-check-label" for="edit_smoking_{{ $room->id }}">Smoking Area</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" id="edit_nosmoking_{{ $room->id }}">
                                                <label class="form-check-label" for="edit_nosmoking_{{ $room->id }}">No Smoking</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" id="edit_refund_{{ $room->id }}">
                                                <label class="form-check-label" for="edit_refund_{{ $room->id }}">Refund</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" id="edit_norefund_{{ $room->id }}">
                                                <label class="form-check-label" for="edit_norefund_{{ $room->id }}">No Refund</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input custom-checkbox" type="checkbox" id="edit_cityview_{{ $room->id }}">
                                                <label class="form-check-label" for="edit_cityview_{{ $room->id }}">City View</label>
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
                            <form action="#" method="POST">
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
                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Room Number / Name</label>
                                <input type="text" class="form-control custom-input" placeholder="e.g. 101 or Superior 1">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Room Type</label>
                                <select class="form-select custom-input">
                                    <option>Deluxe</option>
                                    <option>Superior Double</option>
                                    <option>Executive Suite</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Price per Night (Rp)</label>
                                <input type="number" class="form-control custom-input" placeholder="500000">
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label class="form-label fw-bold">Capacity</label>
                                    <input type="number" class="form-control custom-input" placeholder="2">
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
                                            <input class="form-check-input custom-checkbox" type="checkbox" id="add_wifi">
                                            <label class="form-check-label" for="add_wifi">Wi-Fi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" id="add_tv">
                                            <label class="form-check-label" for="add_tv">TV</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" id="add_minibar">
                                            <label class="form-check-label" for="add_minibar">Mini Bar</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" id="add_smoking">
                                            <label class="form-check-label" for="add_smoking">Smoking Area</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" id="add_nosmoking">
                                            <label class="form-check-label" for="add_nosmoking">No Smoking</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" id="add_refund">
                                            <label class="form-check-label" for="add_refund">Refund</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" id="add_norefund">
                                            <label class="form-check-label" for="add_norefund">No Refund</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input custom-checkbox" type="checkbox" id="add_cityview">
                                            <label class="form-check-label" for="add_cityview">City View</label>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>