<div class="glass-card p-3 shadow-sm" style="border-radius: 15px; background: white; border: 1px solid #f0f0f0; min-height: 100%;">
    <div class="text-center mb-4 mt-2">
        <div class="position-relative d-inline-block">
            <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                 style="width: 110px; height: 110px; background-color: #f3a94a; color: white; border: 4px solid #fff; overflow: hidden;">
                
                @if(Auth::user()->image)
                    <img src="{{ asset('storage/'.Auth::user()->image) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <span style="font-size: 35px; font-weight: bold;">JS</span>
                @endif
            </div>

            <div class="position-absolute bottom-0 end-0 bg-dark rounded-circle d-flex align-items-center justify-content-center shadow" 
                 style="width: 30px; height: 30px; border: 2px solid white; cursor: pointer;">
                <i class="fas fa-camera text-white" style="font-size: 12px;"></i>
            </div>
        </div>
    </div>

    <ul class="nav flex-column profile-menu">
        <li class="nav-item mb-1">
            <a href="{{ route('profile.cards') }}" 
               class="nav-link d-flex align-items-center {{ Request::is('profile/cards*') ? 'active-orange' : 'text-dark' }}" 
               style="padding: 12px 15px; border-radius: 8px; text-decoration: none; transition: 0.3s;">
                <i class="fas fa-credit-card me-3" style="width: 20px;"></i> 
                <span>Kartu Saya</span>
            </a>
        </li>
        
        <li class="nav-item mb-1">
            <a href="{{ route('profile.ewallet') }}" 
               class="nav-link d-flex align-items-center {{ Request::is('profile/e-wallet*') ? 'active-orange' : 'text-dark' }}" 
               style="padding: 12px 15px; border-radius: 8px; text-decoration: none; transition: 0.3s;">
                <i class="fas fa-wallet me-3" style="width: 20px;"></i> 
                <span>E-Wallet Saya</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a href="{{ route('profile.orders') }}" 
               class="nav-link d-flex align-items-center {{ Request::is('profile/orders*') ? 'active-orange' : 'text-dark' }}" 
               style="padding: 12px 15px; border-radius: 8px; text-decoration: none; transition: 0.3s;">
                <i class="fas fa-file-alt me-3" style="width: 20px;"></i> 
                <span>Pesanan Saya</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a href="#" 
               class="nav-link d-flex align-items-center text-dark" 
               style="padding: 12px 15px; border-radius: 8px; text-decoration: none; transition: 0.3s;">
                <i class="fas fa-undo me-3" style="width: 20px;"></i> 
                <span>Refunds</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a href="{{ route('profile') }}" 
               class="nav-link d-flex align-items-center {{ Request::is('profile') ? 'active-orange' : 'text-dark' }}" 
               style="padding: 12px 15px; border-radius: 8px; text-decoration: none; transition: 0.3s;">
                <i class="fas fa-user-cog me-3" style="width: 20px;"></i> 
                <span>My Account</span>
            </a>
        </li>

        <li class="nav-item mt-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link d-flex align-items-center text-danger border-0 bg-transparent w-100" 
                        style="padding: 12px 15px; border-radius: 8px; transition: 0.3s;">
                    <i class="fas fa-power-off me-3" style="width: 20px;"></i> 
                    <span>Log Out</span>
                </button>
            </form>
        </li>
    </ul>
</div>

<style>
    /* Style untuk menu yang aktif */
    .active-orange {
        background-color: #f3a94a !important;
        color: white !important;
        font-weight: 500;
        box-shadow: 0 4px 10px rgba(243, 169, 74, 0.2);
    }

    /* Hover effect untuk menu yang tidak aktif */
    .nav-link:hover:not(.active-orange):not(.text-danger) {
        background-color: #fff5e6;
        color: #f3a94a !important;
    }

    .nav-link i {
        font-size: 1.1rem;
    }
</style>