@extends('layouts.app')

@section('content')
@php
    $checkinRaw = request('checkin', '2026-05-29');
    $checkoutRaw = request('checkout', '2026-05-30');
    
    try {
        $checkinFormatted = \Carbon\Carbon::parse($checkinRaw)->translatedFormat('D, d M Y');
        $checkoutFormatted = \Carbon\Carbon::parse($checkoutRaw)->translatedFormat('D, d M Y');
    } catch (\Exception $e) {
        $checkinFormatted = $checkinRaw;
        $checkoutFormatted = $checkoutRaw;
    }
@endphp

<div class="room-selection-wrapper" style="background-color: #f8f9fa; min-height: 100vh; font-family: 'Poppins', 'Montserrat', sans-serif;">
    
    <div class="room-navbar" style="background: #ffffff; border-bottom: 1px solid #eef2f5; padding: 12px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        <div class="navbar-content container" style="max-width: 1160px; margin: 0 auto; padding: 0 1rem; display: flex; align-items: center;">
            <a href="{{ route('bookings.index') }}" class="back-link" style="text-decoration: none; color: #e69c24; font-weight: 700; font-size: 0.95rem; letter-spacing: 1px; display: inline-flex; align-items: center; gap: 8px;">
                <span class="back-arrow" style="font-size: 1.1rem;">&#10094;</span> PILIH KAMAR
            </a>
        </div>
    </div>

    <div class="room-main-container container" style="max-width: 1160px; margin: 0 auto; padding: 2rem 1rem;">
        
        <div class="search-summary-box" style="background: #ffffff; border-radius: 10px; padding: 14px 24px; margin-bottom: 2rem; box-shadow: 0 4px 20px rgba(0,0,0,0.04); border: 1px solid #eef2f5;">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; align-items: center;">
                <div style="padding-right: 15px;">
                    <p style="color: #8c94a0; margin: 0 0 2px 0; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;">Check-in</p>
                    <h5 style="font-weight: 600; color: #1a1f2c; margin: 0; font-size: 0.95rem;">{{ $checkinFormatted }}</h5>
                </div>
                <div style="border-left: 1px solid #eef2f5; padding-left: 20px; padding-right: 15px;">
                    <p style="color: #8c94a0; margin: 0 0 2px 0; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;">Check-out</p>
                    <h5 style="font-weight: 600; color: #1a1f2c; margin: 0; font-size: 0.95rem;">{{ $checkoutFormatted }}</h5>
                </div>
                <div style="border-left: 1px solid #eef2f5; padding-left: 20px; padding-right: 15px;">
                    <p style="color: #8c94a0; margin: 0 0 2px 0; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;">Tamu</p>
                    <h5 style="font-weight: 600; color: #1a1f2c; margin: 0; font-size: 0.95rem;">{{ request('guests', '2') }} Orang</h5>
                </div>
                <div style="border-left: 1px solid #eef2f5; padding-left: 20px;">
                    <p style="color: #8c94a0; margin: 0 0 2px 0; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase;">Kamar</p>
                    <h5 style="font-weight: 600; color: #1a1f2c; margin: 0; font-size: 0.95rem;">{{ request('rooms', '1') }} Kamar</h5>
                </div>
            </div>
        </div>
        
        @forelse($resources as $resource)
        <div class="room-card">
            <h2 class="room-title">{{ $resource->name }}</h2>
            
            <div class="room-card-body">
                <div class="room-details-column">
                    <div class="room-image-wrapper">
                        <img src="{{ $resource->image ?? asset('assets/img/bg.png') }}" alt="{{ $resource->name }}" class="room-img">
                    </div>
                    
                    <div class="room-spec">
                        <span class="spec-size">📐 {{ $resource->size ?? '28.0 m²' }}</span>
                        <span class="spec-capacity" style="margin-left: 10px;">👥 {{ $resource->max_adults }} Adult, {{ $resource->max_children }} Children</span>
                    </div>

                    <div class="room-facilities-grid">
                        @if($resource->facilities)
                            @foreach(explode(',', $resource->facilities) as $facility)
                                <div class="facility-item">{{ trim($facility) }}</div>
                            @endforeach
                        @else
                            <div class="facility-item">🚿 Shower</div>
                            <div class="facility-item">❄️ AC</div>
                            <div class="facility-item">📶 WiFi</div>
                        @endif
                    </div>

                    <a href="javascript:void(0)" class="see-detail-link" onclick="openRoomDetail({{ json_encode($resource->name) }}, {{ json_encode($resource->type) }}, {{ json_encode($resource->max_adults . ' Adult, ' . $resource->max_children . ' Children') }}, {{ json_encode($resource->size ?? '28.0 m²') }}, {{ json_encode($resource->description) }}, {{ json_encode($resource->image) }}, {{ json_encode($resource->facilities) }})">See Room Details</a>
                </div>

                <div class="room-table-column">
                    <table class="prices-table">
                        <thead>
                            <tr>
                                <th width="45%">Room Option(s)</th>
                                <th width="15%">Guest(s)</th>
                                <th width="25%">Price/room/night</th>
                                <th width="15%">Room</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="option-info">
                                    <span class="sub-title">{{ $resource->name }} - Room Only</span>
                                    <h4>Without Breakfast</h4>
                                    <p class="bed-info">🛏️ 1 double bed</p>
                                    <p class="policy-info text-muted">🔄 Non-Refundable</p>
                                </td>
                                <td class="text-center" style="font-size: 1.5rem;">👥</td>
                                <td class="price-amount">Rp {{ number_format($resource->price_per_hour, 0, ',', '.') }}</td>
                                <td class="text-center text-muted">x1</td>
                                <td class="text-center">
                                    <form action="{{ route('bookings.review') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="resource_id" value="{{ $resource->id }}">
                                        <input type="hidden" name="checkin" value="{{ $checkinRaw }}">
                                        <input type="hidden" name="checkout" value="{{ $checkoutRaw }}">
                                        <input type="hidden" name="room_name" value="{{ $resource->name }}">
                                        <input type="hidden" name="option_type" value="Room Only">
                                        <input type="hidden" name="price" value="{{ $resource->price_per_hour }}">
                                        <button type="submit" class="btn-choose">Choose</button>
                                    </form>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="option-info">
                                    <span class="sub-title">{{ $resource->name }} - Breakfast</span>
                                    <h4>Breakfast for 2</h4>
                                    <p class="bed-info">🛏️ 1 double bed</p>
                                    <p class="policy-info text-muted">🔄 Non-Refundable</p>
                                </td>
                                <td class="text-center" style="font-size: 1.5rem;">👥</td>
                                <td class="price-amount">Rp {{ number_format($resource->price_per_hour + 75000, 0, ',', '.') }}</td>
                                <td class="text-center text-muted">x1</td>
                                <td class="text-center">
                                    <form action="{{ route('bookings.review') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="resource_id" value="{{ $resource->id }}">
                                        <input type="hidden" name="checkin" value="{{ $checkinRaw }}">
                                        <input type="hidden" name="checkout" value="{{ $checkoutRaw }}">
                                        <input type="hidden" name="room_name" value="{{ $resource->name }}">
                                        <input type="hidden" name="option_type" value="Breakfast for 2">
                                        <input type="hidden" name="price" value="{{ $resource->price_per_hour + 75000 }}">
                                        <button type="submit" class="btn-choose">Choose</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @empty
        <div class="room-card" style="padding: 40px; text-align: center;">
            <i class="fa-solid fa-bed" style="font-size: 4rem; color: #ccc; margin-bottom: 15px;"></i>
            <h3 style="font-weight: bold; color: #333;">Kamar Tidak Tersedia</h3>
            <p style="color: #777; margin-bottom: 0;">Maaf, tidak ada tipe kamar yang cocok dengan parameter pencarian Anda di database.</p>
        </div>
        @endforelse

    </div>
</div>

<div id="roomDetailModal" class="rd-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 1rem;">
    <div class="rd-modal-overlay" style="position: absolute; inset: 0;" onclick="closeRoomDetail()"></div>
    
    <div class="rd-modal-content" style="position: relative; background: #ffffff; width: 100%; max-width: 920px; border-radius: 14px; box-shadow: 0 15px 40px rgba(0,0,0,0.25); overflow: hidden; display: flex; flex-direction: row; animation: rdSlideUp 0.25s ease-out;">
        
        <button class="rd-close-btn" onclick="closeRoomDetail()" style="position: absolute; top: 15px; right: 20px; border: none; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); width: 36px; height: 36px; border-radius: 50%; font-size: 1.3rem; font-weight: bold; color: #666; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: all 0.2s;">&times;</button>
        
        <div class="rd-left-specs" style="flex: 1.1; padding: 35px; overflow-y: auto; max-height: 85vh;">
            <span id="md-room-type" style="background: rgba(230, 156, 36, 0.1); color: #e69c24; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Double Bed</span>
            <h2 id="md-room-name" style="font-size: 1.8rem; font-weight: 700; color: #1a1f2c; margin: 10px 0 15px 0;">Superior Double</h2>
            
            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 15px;">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 10px; color: #4a5568; font-size: 0.9rem;">
                    <span style="font-size: 1.1rem;">📐</span> <strong>Room Size:</strong> <span id="md-room-size">28 m²</span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; color: #4a5568; font-size: 0.9rem;">
                    <span style="font-size: 1.1rem;">👥</span> <strong>Capacity:</strong> <span id="md-room-capacity">2 Adult, 1 Children</span>
                </div>
            </div>

            <h5 style="font-size: 0.95rem; font-weight: 700; color: #333; margin-bottom: 8px;">Room Description</h5>
            <p id="md-room-desc" style="font-size: 0.88rem; color: #666; line-height: 1.6; text-align: justify; margin-bottom: 20px;">Detailed room description.</p>
            
            <h5 style="font-size: 0.95rem; font-weight: 700; color: #333; margin-bottom: 12px;">Room Facilities</h5>
            <div id="md-room-facilities" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 0.85rem; color: #555;">
                <div>🚿 Private Bathroom (Shower)</div>
                <div>❄️ Air Conditioning (AC)</div>
                <div>📶 High-Speed Free Wi-Fi</div>
                <div>📺 Smart TV & Satellite Channels</div>
                <div>🔲 Mini Fridge</div>
                <div>☕ Coffee & Tea Maker</div>
                <div>🔒 Safe Deposit Box</div>
                <div>💨 Hairdryer</div>
            </div>
        </div>
        
        <div class="rd-right-photos" style="flex: 0.9; background: #fcfcfc; border-left: 1px solid #f0f0f0; padding: 25px; display: flex; flex-direction: column; gap: 12px; justify-content: center; max-height: 85vh;">
            <p style="margin: 0; font-size: 0.75rem; font-weight: 700; color: #999; text-uppercase; letter-spacing: 0.5px;">Property Photo Gallery</p>
            <div style="width: 100%; height: 240px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <img id="md-main-img" src="" alt="Foto Utama" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div style="height: 100px; border-radius: 6px; overflow: hidden; cursor: pointer;" onclick="switchMainPhoto(this.children[0].src)">
                    <img id="md-thumb-1" src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=400" alt="Detail 1" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s;">
                </div>
                <div style="height: 100px; border-radius: 6px; overflow: hidden; cursor: pointer;" onclick="switchMainPhoto(this.children[0].src)">
                    <img id="md-thumb-2" src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=400" alt="Detail 2" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s;">
                </div>
            </div>
        </div>

    </div>
</div>

<style>
@keyframes rdSlideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.rd-close-btn:hover { background: #e69c24 !important; color: #ffffff !important; }
@media (max-width: 768px) {
    .rd-modal-content { flex-direction: column-reverse !important; max-height: 90vh; overflow-y: auto; }
    .rd-right-photos { border-left: none !important; border-bottom: 1px solid #f0f0f0 !important; }
}
</style>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pilih-kamar.css') }}?v={{ time() }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/js/pilih-kamar.js') }}?v={{ time() }}"></script>
@endpush

@endsection