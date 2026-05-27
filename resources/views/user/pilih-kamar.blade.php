<div class="room-selection-wrapper">
    
    <!-- NAVBAR UTAMA (Atas) -->
    <div class="room-navbar">
        <div class="navbar-content">
            <a href="#" class="back-link">
                <span class="back-arrow">&#10094;</span> PILIH KAMAR
            </a>
        </div>
    </div>

    <!-- UTAMA CONTAINER CARD -->
    <div class="room-main-container">
        
        <!-- ============================== -->
        <!-- CARD KAMAR 1: Superior Double  -->
        <!-- ============================== -->
        <div class="room-card">
            <h2 class="room-title">Superior Double</h2>
            
            <div class="room-card-body">
                <!-- KOLOM KIRI: Foto & Fasilitas -->
                <div class="room-details-column">
                    <div class="room-image-wrapper">
                        <img src="{{ asset('assets/img/bg.png') }}" alt="Superior Double Room" class="room-img">
                    </div>
                    
                    <div class="room-spec">
                        <span class="spec-size">📐 28.0 m</span>
                    </div>

                    <div class="room-facilities-grid">
                        <div class="facility-item">🚿 Shower</div>
                        <div class="facility-item">🔲 Refrigerator</div>
                        <div class="facility-item">♨️ Hot water</div>
                        <div class="facility-item">❄️ Air Conditioning</div>
                        <div class="facility-item">📶 Free WiFi</div>
                    </div>

                    <a href="#" class="see-detail-link">See Room Details</a>
                </div>

                <!-- KOLOM KANAN: Tabel Opsi Harga -->
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
                            <!-- Opsi 1: Room Only -->
                            <tr>
                                <td class="option-info">
                                    <span class="sub-title">Superior Double - Room Only</span>
                                    <h4>Without Breakfast</h4>
                                    <p class="bed-info">🛏️ 1 double bed</p>
                                    <p class="policy-info text-muted">🔄 Non-Refundable</p>
                                </td>
                                <td class="text-center text-xl">👥</td>
                                <td class="price-amount">Rp 445.000</td>
                                <td class="text-center text-muted">x1</td>
                                <td class="text-center">
                                    <!-- FORM POST UNTUK MENGHUBUNGKAN KE REVIEW -->
                                    <form action="{{ route('user.review') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="room_name" value="Superior Double">
                                        <input type="hidden" name="option_type" value="Room Only">
                                        <input type="hidden" name="bed_info" value="1 double bed">
                                        <input type="hidden" name="breakfast_info" value="Without Breakfast">
                                        <input type="hidden" name="price" value="445000">
                                        <button type="submit" class="btn-choose">Choose</button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Opsi 2: Breakfast -->
                            <tr>
                                <td class="option-info">
                                    <span class="sub-title">Superior Double - Breakfast</span>
                                    <h4>Breakfast for 2</h4>
                                    <p class="bed-info">🛏️ 1 double bed</p>
                                    <p class="policy-info text-muted">🔄 Non-Refundable</p>
                                </td>
                                <td class="text-center text-xl">👥</td>
                                <td class="price-amount">Rp 520.000</td>
                                <td class="text-center text-muted">x1</td>
                                <td class="text-center">
                                    <form action="{{ route('user.review') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="room_name" value="Superior Double">
                                        <input type="hidden" name="option_type" value="Breakfast">
                                        <input type="hidden" name="bed_info" value="1 double bed">
                                        <input type="hidden" name="breakfast_info" value="Breakfast for 2">
                                        <input type="hidden" name="price" value="520000">
                                        <button type="submit" class="btn-choose">Choose</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ============================== -->
        <!-- CARD KAMAR 2: Deluxe Twin      -->
        <!-- ============================== -->
        <div class="room-card">
            <h2 class="room-title">Deluxe Twin</h2>
            
            <div class="room-card-body">
                <div class="room-details-column">
                    <div class="room-image-wrapper">
                        <img src="{{ asset('assets/img/bg.png') }}" alt="Deluxe Twin Room" class="room-img">
                    </div>
                    
                    <div class="room-spec">
                        <span class="spec-size">📐 32.0 m</span>
                    </div>

                    <div class="room-facilities-grid">
                        <div class="facility-item">🚿 Shower</div>
                        <div class="facility-item">🔲 Refrigerator</div>
                        <div class="facility-item">♨️ Hot water</div>
                        <div class="facility-item">❄️ Air Conditioning</div>
                        <div class="facility-item">📶 Free WiFi</div>
                    </div>

                    <a href="#" class="see-detail-link">See Room Details</a>
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
                            <!-- Opsi 1: Room Only -->
                            <tr>
                                <td class="option-info">
                                    <span class="sub-title">Deluxe Twin - Room Only</span>
                                    <h4>Without Breakfast</h4>
                                    <p class="bed-info">🛏️ 2 single beds</p>
                                    <p class="policy-info text-muted">🔄 Non-Refundable</p>
                                </td>
                                <td class="text-center text-xl">👥</td>
                                <td class="price-amount">Rp 550.000</td>
                                <td class="text-center text-muted">x1</td>
                                <td class="text-center">
                                    <form action="{{ route('user.review') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="room_name" value="Deluxe Twin">
                                        <input type="hidden" name="option_type" value="Room Only">
                                        <input type="hidden" name="bed_info" value="2 single beds">
                                        <input type="hidden" name="breakfast_info" value="Without Breakfast">
                                        <input type="hidden" name="price" value="550000">
                                        <button type="submit" class="btn-choose">Choose</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- Opsi 2: Breakfast -->
                            <tr>
                                <td class="option-info">
                                    <span class="sub-title">Deluxe Twin - Breakfast</span>
                                    <h4>Breakfast for 2</h4>
                                    <p class="bed-info">🛏️ 2 single beds</p>
                                    <p class="policy-info text-muted">✅ Free Cancellation</p>
                                </td>
                                <td class="text-center text-xl">👥</td>
                                <td class="price-amount">Rp 650.000</td>
                                <td class="text-center text-muted">x1</td>
                                <td class="text-center">
                                    <form action="{{ route('user.review') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="room_name" value="Deluxe Twin">
                                        <input type="hidden" name="option_type" value="Breakfast">
                                        <input type="hidden" name="bed_info" value="2 single beds">
                                        <input type="hidden" name="breakfast_info" value="Breakfast for 2">
                                        <input type="hidden" name="price" value="650000">
                                        <button type="submit" class="btn-choose">Choose</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ============================== -->
        <!-- CARD KAMAR 3: Executive Suite  -->
        <!-- ============================== -->
        <div class="room-card">
            <h2 class="room-title">Executive Suite</h2>
            
            <div class="room-card-body">
                <div class="room-details-column">
                    <div class="room-image-wrapper">
                        <img src="{{ asset('assets/img/bg.png') }}" alt="Executive Suite" class="room-img">
                    </div>
                    
                    <div class="room-spec">
                        <span class="spec-size">📐 45.0 m</span>
                    </div>

                    <div class="room-facilities-grid">
                        <div class="facility-item">🛁 Bathtub</div>
                        <div class="facility-item">📺 Smart TV</div>
                        <div class="facility-item">♨️ Hot water</div>
                        <div class="facility-item">❄️ Air Conditioning</div>
                        <div class="facility-item">📶 Free WiFi</div>
                    </div>

                    <a href="#" class="see-detail-link">See Room Details</a>
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
                                    <span class="sub-title">Executive Suite - Breakfast</span>
                                    <h4>Breakfast for 2</h4>
                                    <p class="bed-info">🛏️ 1 king bed</p>
                                    <p class="policy-info text-muted">✅ Free Cancellation</p>
                                </td>
                                <td class="text-center text-xl">👥</td>
                                <td class="price-amount">Rp 950.000</td>
                                <td class="text-center text-muted">x1</td>
                                <td class="text-center">
                                    <form action="{{ route('user.review') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="room_name" value="Executive Suite">
                                        <input type="hidden" name="option_type" value="Breakfast">
                                        <input type="hidden" name="bed_info" value="1 king bed">
                                        <input type="hidden" name="breakfast_info" value="Breakfast for 2">
                                        <input type="hidden" name="price" value="950000">
                                        <button type="submit" class="btn-choose">Choose</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ============================== -->
        <!-- CARD KAMAR 4: Presidential     -->
        <!-- ============================== -->
        <div class="room-card">
            <h2 class="room-title">Presidential Suite</h2>
            
            <div class="room-card-body">
                <div class="room-details-column">
                    <div class="room-image-wrapper">
                        <img src="{{ asset('assets/img/bg.png') }}" alt="Presidential Suite" class="room-img">
                    </div>
                    
                    <div class="room-spec">
                        <span class="spec-size">📐 80.0 m</span>
                    </div>

                    <div class="room-facilities-grid">
                        <div class="facility-item">🏊 Private Pool</div>
                        <div class="facility-item">🍽️ Dining Area</div>
                        <div class="facility-item">🛁 Jacuzzi</div>
                        <div class="facility-item">❄️ Air Conditioning</div>
                        <div class="facility-item">📶 Free WiFi</div>
                    </div>

                    <a href="#" class="see-detail-link">See Room Details</a>
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
                                    <span class="sub-title">Presidential Suite - All Inclusive</span>
                                    <h4>Breakfast, Lunch & Dinner</h4>
                                    <p class="bed-info">🛏️ 1 super king bed</p>
                                    <p class="policy-info text-muted">✅ Free Cancellation</p>
                                </td>
                                <td class="text-center text-xl">👥</td>
                                <td class="price-amount">Rp 2.500.000</td>
                                <td class="text-center text-muted">x1</td>
                                <td class="text-center">
                                    <form action="{{ route('user.review') }}" method="GET">
                                        @csrf
                                        <input type="hidden" name="room_name" value="Presidential Suite">
                                        <input type="hidden" name="option_type" value="All Inclusive">
                                        <input type="hidden" name="bed_info" value="1 super king bed">
                                        <input type="hidden" name="breakfast_info" value="Breakfast, Lunch & Dinner">
                                        <input type="hidden" name="price" value="2500000">
                                        <button type="submit" class="btn-choose">Choose</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END CARD KAMAR 4 -->

    </div>
</div>

<link rel="stylesheet" href="{{ asset('assets/css/pilih-kamar.css') }}?v={{ time() }}">