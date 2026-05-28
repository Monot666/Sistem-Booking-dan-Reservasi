// ==========================================================================
// INTERACTIVE SPECIAL REQUESTS LOGIC - ROOMLY PLATFORM
// ==========================================================================

document.addEventListener("DOMContentLoaded", function() {
    // Ambil elemen checkbox dan kontainer input target
    const chkLainnya = document.getElementById('chk-lainnya');
    const boxLainnya = document.getElementById('box-lainnya');
    
    const chkCheckin = document.getElementById('chk-checkin');
    const boxCheckin = document.getElementById('box-checkin');
    
    const chkCheckout = document.getElementById('chk-checkout');
    const boxCheckout = document.getElementById('box-checkout');

    /**
     * Fungsi reusable untuk menampilkan/menyembunyikan input kustom
     * @param {Element} checkbox 
     * @param {Element} targetBox 
     */
    function toggleInputBox(checkbox, targetBox) {
        if (checkbox && targetBox) {
            if (checkbox.checked) {
                targetBox.style.display = "block";
            } else {
                targetBox.style.display = "none";
            }
        }
    }

    // Jalankan Event Listener dan inisialisasi awal saat halaman dimuat
    if (chkLainnya && boxLainnya) {
        chkLainnya.addEventListener('change', () => toggleInputBox(chkLainnya, boxLainnya));
        toggleInputBox(chkLainnya, boxLainnya);
    }
    
    if (chkCheckin && boxCheckin) {
        chkCheckin.addEventListener('change', () => toggleInputBox(chkCheckin, boxCheckin));
        toggleInputBox(chkCheckin, boxCheckin);
    }
    
    if (chkCheckout && boxCheckout) {
        chkCheckout.addEventListener('change', () => toggleInputBox(chkCheckout, boxCheckout));
        toggleInputBox(chkCheckout, boxCheckout);
    }
});