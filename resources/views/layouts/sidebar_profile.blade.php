<div class="profile-card">
    <div class="avatar-section">
        <div class="avatar-wrapper">
            <img id="avatar-preview" 
                 src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=f3f4f6&color=333' }}" 
                 alt="Foto Profil"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=333'">
            
            <label for="avatar_upload" class="camera-btn" title="Ubah Foto">
                <i class="fas fa-camera"></i>
            </label>

            <input type="file" id="avatar_upload" name="avatar" class="d-none" accept="image/*" form="profile-form" onchange="previewAvatar(event)">
        </div>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('profile.cards') }}" class="{{ request()->routeIs('profile.cards') ? 'active' : '' }}">
                <i class="fa-regular fa-credit-card"></i> Kartu Saya
            </a>
        </li>
        <li>
            <a href="{{ route('profile.ewallet') }}" class="{{ request()->routeIs('profile.ewallet') ? 'active' : '' }}">
                <i class="fa-solid fa-wallet"></i> E-Wallet Saya
            </a>
        </li>
        <li>
            <a href="{{ route('profile.orders') }}" class="{{ request()->routeIs('profile.orders') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice"></i> Pesanan Saya
            </a>
        </li>
        <li>
            <a href="{{ route('profile.refunds') ?? '#' }}" class="{{ request()->routeIs('profile.refunds') ? 'active' : '' }}">
                <i class="fa-solid fa-hand-holding-dollar"></i> Refunds
            </a>
        </li>
        <li>
            <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> My Account
            </a>
        </li>
        <li>
            <button type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <i class="fa-solid fa-power-off"></i> Log Out
            </button>
        </li>
    </ul>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body text-center pt-2 pb-4">
                <i class="fa-solid fa-arrow-right-from-bracket mb-3" style="font-size: 3.5rem; color: #df9e38;"></i>
                <p class="mb-0" style="font-size: 1.1rem; color: #4b5563;">Apakah Anda yakin ingin logout?</p>
            </div>
            
            <div class="modal-footer border-0 pt-0 d-flex justify-content-center gap-2 pb-4">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 6px; font-weight: 500;">Batal</button>
                
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn px-4" style="background-color: #ef4444; color: white; border-radius: 6px; font-weight: 500;">Ya, Keluar</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>