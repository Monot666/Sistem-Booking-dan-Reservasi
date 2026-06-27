<div class="profile-card">
    <div class="avatar-section">
        <div class="avatar-wrapper">
            <img id="avatar-preview" 
                 src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=f3f4f6&color=333' }}" 
                 alt="Foto Profil"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=333'">
            
            <label for="avatar_upload" class="camera-btn" title="Ubah Foto">
                <i class="fas fa-camera"></i>
            </label>

            <input type="file" id="avatar_upload" name="avatar" class="d-none" accept="image/*" onchange="previewAvatar(event)">
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