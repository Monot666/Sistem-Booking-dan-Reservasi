// ==========================================================================
// INDEPENDENT JAVASCRIPT FOR ROOM DETAIL MODAL (Roomly Platform)
// ==========================================================================

/**
 * Fungsi Interaktif Membuka Modal Pop-up Detail Kamar
 */
function openRoomDetail(name, type, capacity, size, description, mainImage) {
    document.getElementById('md-room-name').textContent = name;
    document.getElementById('md-room-type').textContent = type;
    document.getElementById('md-room-capacity').textContent = capacity + " Orang";
    document.getElementById('md-room-size').textContent = size;
    document.getElementById('md-room-desc').textContent = description;
    
    // PERBAIKAN: Di file .js eksternal, kita ganti {{ asset() }} menjadi path string absolut biasa
    const fallbackImg = mainImage ? mainImage : '/assets/img/bg.png';
    document.getElementById('md-main-img').src = fallbackImg;
    
    // Tampilkan Modal dengan display flex
    document.getElementById('roomDetailModal').style.display = 'flex';
}

/**
 * Fungsi Menutup Pop-up Detail Kamar
 */
function closeRoomDetail() {
    document.getElementById('roomDetailModal').style.display = 'none';
}

/**
 * Fitur Interaktif: Mengubah Foto Utama Saat Thumbnail Diklik
 */
function switchMainPhoto(src) {
    const mainImg = document.getElementById('md-main-img');
    mainImg.style.opacity = 0.5;
    setTimeout(() => {
        mainImg.src = src;
        mainImg.style.opacity = 1;
    }, 100);
}