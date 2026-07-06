<!DOCTYPE html>
<html lang="en">
<head>
    <title>Content Creator - Roomly</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/content_creator/style.css') }}">
</head>
<body>

@php
    $groupedBanners = $banners->groupBy('layout_name');

    $getBanner = function($layout, $pos) use ($groupedBanners) {
        $banner = $groupedBanners->get($layout)?->firstWhere('position', $pos);
        $image = $banner?->image_path;
        $imageUrl = $image ? (str_starts_with($image, 'http') ? $image : asset($image)) : '';
        $link = $banner?->external_link ?? '';
        return ['image' => $imageUrl, 'link' => $link];
    };

    $dash = $getBanner('Dashboard', 'Foto 1');
    
    // Dashboard Explore kini hanya 3 Foto
    $expl1 = $getBanner('Dashboard Explore', 'Foto 1');
    $expl2 = $getBanner('Dashboard Explore', 'Foto 2');
    $expl3 = $getBanner('Dashboard Explore', 'Foto 3');
    
    // Layout Baru: Fasilitas Hotel (4 Foto)
    $fasil1 = $getBanner('Fasilitas Hotel', 'Foto 1');
    $fasil2 = $getBanner('Fasilitas Hotel', 'Foto 2');
    $fasil3 = $getBanner('Fasilitas Hotel', 'Foto 3');
    $fasil4 = $getBanner('Fasilitas Hotel', 'Foto 4');

    $ord = $getBanner('Order', 'Foto 1');
    $pay1 = $getBanner('Pembayaran', 'Foto 1');
    $pay2 = $getBanner('Pembayaran', 'Foto 2');
    $conf = $getBanner('Konfirmasi Pembayaran', 'Foto 1');
@endphp

<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="logo-area">
            <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="Logo">
            <div class="logo-text">
                <h4>Roomly Content</h4>
                <small>Creator Portal</small>
            </div>
        </div>
        <ul class="nav-links" style="display: flex; flex-direction: column; gap: 5px;">
            <li class="active" id="nav-dashboard">
                <a href="javascript:void(0)" onclick="showLayoutSelection()"><i class="fas fa-th-large"></i> Dashboard</a>
            </li>
            <li style="margin-top: auto;">
                <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" style="border: none; background: transparent;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </aside>

    <main class="main-content" style="background-color: #f4f7fe; min-height: 100vh;">
        
        <div id="view-selection">
            <h2 class="fw-bold mb-4" style="color: #2b3674; font-size: 1.8rem;">Pilih Layout</h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="layout-card">
                        <img src="{{ asset('assets/img/content_creator/dashboard.png') }}" alt="Dashboard" class="layout-img">
                        <p class="layout-name">Dashboard</p>
                        <button class="btn-pilih" onclick="showEditLayout('Dashboard', '{{ asset('assets/img/content_creator/dashboard.png') }}', '{{ $dash['image'] }}', '{{ $dash['link'] }}')">Pilih</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="layout-card">
                        <img src="{{ asset('assets/img/content_creator/dashboard-explore.png') }}" alt="Dashboard Explore" class="layout-img">
                        <p class="layout-name">Dashboard Explore</p>
                        <button class="btn-pilih" onclick="showEditLayout('Dashboard Explore', '{{ asset('assets/img/content_creator/dashboard-explore.png') }}', '{{ $expl1['image'] }}', '{{ $expl1['link'] }}', '{{ $expl2['image'] }}', '{{ $expl2['link'] }}', '{{ $expl3['image'] }}', '{{ $expl3['link'] }}')">Pilih</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="layout-card">
                        <img src="{{ asset('assets/img/content_creator/dashboard-explore.png') }}" alt="Fasilitas Hotel" class="layout-img">
                        <p class="layout-name">Fasilitas Hotel</p>
                        <button class="btn-pilih" onclick="showEditLayout('Fasilitas Hotel', '{{ asset('assets/img/content_creator/dashboard-explore.png') }}', '{{ $fasil1['image'] }}', '{{ $fasil1['link'] }}', '{{ $fasil2['image'] }}', '{{ $fasil2['link'] }}', '{{ $fasil3['image'] }}', '{{ $fasil3['link'] }}', '{{ $fasil4['image'] }}', '{{ $fasil4['link'] }}')">Pilih</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="layout-card">
                        <img src="{{ asset('assets/img/content_creator/order.png') }}" alt="Order" class="layout-img">
                        <p class="layout-name">Order</p>
                        <button class="btn-pilih" onclick="showEditLayout('Order', '{{ asset('assets/img/content_creator/order.png') }}', '{{ $ord['image'] }}', '{{ $ord['link'] }}')">Pilih</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="layout-card">
                        <img src="{{ asset('assets/img/content_creator/pembayaran.png') }}" alt="Pembayaran" class="layout-img">
                        <p class="layout-name">Pembayaran</p>
                        <button class="btn-pilih" onclick="showEditLayout('Pembayaran', '{{ asset('assets/img/content_creator/pembayaran.png') }}', '{{ $pay1['image'] }}', '{{ $pay1['link'] }}', '{{ $pay2['image'] }}', '{{ $pay2['link'] }}')">Pilih</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="layout-card">
                        <img src="{{ asset('assets/img/content_creator/konfirmasi-pembayaran.png') }}" alt="Konfirmasi Pembayaran" class="layout-img">
                        <p class="layout-name">Konfirmasi Pembayaran</p>
                        <button class="btn-pilih" onclick="showEditLayout('Konfirmasi Pembayaran', '{{ asset('assets/img/content_creator/konfirmasi-pembayaran.png') }}', '{{ $conf['image'] }}', '{{ $conf['link'] }}')">Pilih</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="view-upload" style="display: none;">
            <div class="d-flex align-items-center mb-4">
                <button class="btn-back" onclick="showLayoutSelection()"><i class="fas fa-chevron-left"></i></button>
                <h2 class="fw-bold ms-3 mb-0" style="color: #2b3674; font-size: 1.8rem;" id="selected-layout-title">Dashboard</h2>
            </div>

            <div class="upload-container text-center">
                
                <div class="mockup-preview mb-5">
                    <img src="" alt="Mockup" class="img-fluid" style="border-radius: 12px; width: 100%; max-width: 600px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);" id="mockup-image">
                </div>

                <div id="dynamic-upload-zones">
                    <div class="upload-block" id="upload-block-1">
                        <h5 class="fw-bold text-start mb-3" style="color: #df9e4c;">Foto 1</h5>
                        
                        <div class="current-photo-box mb-3 p-4" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <img src="" alt="Current Ad 1" class="current-ad-img mb-3" id="current-ad-image-1" style="cursor: pointer;" onclick="document.getElementById('file-input-1').click()" title="Klik untuk ganti foto">
                            <input type="hidden" id="delete-flag-1" value="0">
                            <div class="d-flex gap-2 justify-content-center mt-2">
                                <button class="btn btn-sm" style="background-color: #2b3674; color: white; border-radius: 6px;" type="button" onclick="document.getElementById('file-input-1').click()"><i class="fas fa-edit me-2"></i>Ganti Foto</button>
                                <button class="btn btn-sm btn-danger" style="border-radius: 6px;" type="button" onclick="deleteAd(1)"><i class="fas fa-trash-alt me-2"></i>Hapus</button>
                            </div>
                        </div>
                        
                        <div class="form-group text-start mb-3" id="link-group-1" style="display: none;">
                            <label class="form-label fw-bold" style="font-size: 0.9rem;">Link Eksternal Foto 1</label>
                            <input type="text" id="link-input-1" class="form-control p-2" placeholder="Masukkan link (contoh: https://...)" style="border-radius: 8px;">
                        </div>

                        <div class="drop-zone mb-4" id="drop-zone-1">
                            <div class="drop-zone-content">
                                <div class="icon-upload-circle"><i class="fas fa-cloud-upload-alt"></i></div>
                                <p class="mt-3 text-muted fw-medium">Klik untuk upload Foto 1 baru</p>
                            </div>
                            <input type="file" id="file-input-1" class="drop-zone__input" hidden accept="image/*">
                        </div>
                    </div>

                    <div class="upload-block mt-5 pt-3" id="upload-block-2" style="display: none; border-top: 2px dashed #e2e8f0;">
                        <h5 class="fw-bold text-start mb-3" style="color: #df9e4c;">Foto 2</h5>
                        
                        <div class="current-photo-box mb-3 p-4" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <img src="" alt="Current Ad 2" class="current-ad-img mb-3" id="current-ad-image-2" style="cursor: pointer;" onclick="document.getElementById('file-input-2').click()" title="Klik untuk ganti foto">
                            <input type="hidden" id="delete-flag-2" value="0">
                            <div class="d-flex gap-2 justify-content-center mt-2">
                                <button class="btn btn-sm" style="background-color: #2b3674; color: white; border-radius: 6px;" type="button" onclick="document.getElementById('file-input-2').click()"><i class="fas fa-edit me-2"></i>Ganti Foto</button>
                                <button class="btn btn-sm btn-danger" style="border-radius: 6px;" type="button" onclick="deleteAd(2)"><i class="fas fa-trash-alt me-2"></i>Hapus</button>
                            </div>
                        </div>

                        <div class="form-group text-start mb-3" id="link-group-2" style="display: none;">
                            <label class="form-label fw-bold" style="font-size: 0.9rem;">Link Eksternal Foto 2</label>
                            <input type="text" id="link-input-2" class="form-control p-2" placeholder="Masukkan link (contoh: https://...)" style="border-radius: 8px;">
                        </div>

                        <div class="drop-zone mb-4" id="drop-zone-2">
                            <div class="drop-zone-content">
                                <div class="icon-upload-circle"><i class="fas fa-cloud-upload-alt"></i></div>
                                <p class="mt-3 text-muted fw-medium">Klik untuk upload Foto 2 baru</p>
                            </div>
                            <input type="file" id="file-input-2" class="drop-zone__input" hidden accept="image/*">
                        </div>
                    </div>

                    <div class="upload-block mt-5 pt-3" id="upload-block-3" style="display: none; border-top: 2px dashed #e2e8f0;">
                        <h5 class="fw-bold text-start mb-3" style="color: #df9e4c;">Foto 3</h5>
                        
                        <div class="current-photo-box mb-3 p-4" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <img src="" alt="Current Ad 3" class="current-ad-img mb-3" id="current-ad-image-3" style="cursor: pointer;" onclick="document.getElementById('file-input-3').click()" title="Klik untuk ganti foto">
                            <input type="hidden" id="delete-flag-3" value="0">
                            <div class="d-flex gap-2 justify-content-center mt-2">
                                <button class="btn btn-sm" style="background-color: #2b3674; color: white; border-radius: 6px;" type="button" onclick="document.getElementById('file-input-3').click()"><i class="fas fa-edit me-2"></i>Ganti Foto</button>
                                <button class="btn btn-sm btn-danger" style="border-radius: 6px;" type="button" onclick="deleteAd(3)"><i class="fas fa-trash-alt me-2"></i>Hapus</button>
                            </div>
                        </div>

                        <div class="form-group text-start mb-3" id="link-group-3" style="display: none;">
                            <label class="form-label fw-bold" style="font-size: 0.9rem;">Link Eksternal Foto 3</label>
                            <input type="text" id="link-input-3" class="form-control p-2" placeholder="Masukkan link (contoh: https://...)" style="border-radius: 8px;">
                        </div>

                        <div class="drop-zone mb-4" id="drop-zone-3">
                            <div class="drop-zone-content">
                                <div class="icon-upload-circle"><i class="fas fa-cloud-upload-alt"></i></div>
                                <p class="mt-3 text-muted fw-medium">Klik untuk upload Foto 3 baru</p>
                            </div>
                            <input type="file" id="file-input-3" class="drop-zone__input" hidden accept="image/*">
                        </div>
                    </div>

                    <div class="upload-block mt-5 pt-3" id="upload-block-4" style="display: none; border-top: 2px dashed #e2e8f0;">
                        <h5 class="fw-bold text-start mb-3" style="color: #df9e4c;">Foto 4</h5>
                        
                        <div class="current-photo-box mb-3 p-4" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <img src="" alt="Current Ad 4" class="current-ad-img mb-3" id="current-ad-image-4" style="cursor: pointer;" onclick="document.getElementById('file-input-4').click()" title="Klik untuk ganti foto">
                            <input type="hidden" id="delete-flag-4" value="0">
                            <div class="d-flex gap-2 justify-content-center mt-2">
                                <button class="btn btn-sm" style="background-color: #2b3674; color: white; border-radius: 6px;" type="button" onclick="document.getElementById('file-input-4').click()"><i class="fas fa-edit me-2"></i>Ganti Foto</button>
                                <button class="btn btn-sm btn-danger" style="border-radius: 6px;" type="button" onclick="deleteAd(4)"><i class="fas fa-trash-alt me-2"></i>Hapus</button>
                            </div>
                        </div>

                        <div class="form-group text-start mb-3" id="link-group-4" style="display: none;">
                            <label class="form-label fw-bold" style="font-size: 0.9rem;">Link Eksternal Foto 4</label>
                            <input type="text" id="link-input-4" class="form-control p-2" placeholder="Masukkan link (contoh: https://...)" style="border-radius: 8px;">
                        </div>

                        <div class="drop-zone mb-4" id="drop-zone-4">
                            <div class="drop-zone-content">
                                <div class="icon-upload-circle"><i class="fas fa-cloud-upload-alt"></i></div>
                                <p class="mt-3 text-muted fw-medium">Klik untuk upload Foto 4 baru</p>
                            </div>
                            <input type="file" id="file-input-4" class="drop-zone__input" hidden accept="image/*">
                        </div>
                    </div>
                </div>

                <button class="btn-upload-submit mt-5 w-100 py-3" id="btn-upload" style="font-size: 1.1rem;">Simpan Perubahan</button>
            </div>
        </div>

    </main>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4 border-0 shadow-lg" style="border-radius: 16px;">
            <div class="mb-3"><i class="fas fa-sign-out-alt text-danger" style="font-size: 3.5rem;"></i></div>
            <h4 class="fw-bold mb-2">Confirm Logout</h4>
            <p class="text-muted mb-4">Are you sure you want to log out from Roomly Content Creator?</p>
            <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 8px; border: 1px solid #e2e8f0;">Cancel</button>
                <form action="{{ url('/logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger fw-bold px-4" style="border-radius: 8px;">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/content_creator/script.js') }}?v={{ time() }}"></script>
</body>
</html>