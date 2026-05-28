// ==========================================================================
// ROOMLY TRANSACTION STATUS LOGIC (INDEPENDENT CODES)
// ==========================================================================

document.addEventListener("DOMContentLoaded", function () {
    
    // --- 1. COUNTDOWN TIMER 24 JAM UNTUK MINIMARKET ---
    const retailTimer = document.getElementById('minimarket-countdown');
    if (retailTimer) {
        let hours = 23, minutes = 59, seconds = 59;

        function startRetailTimer() {
            if (seconds > 0) {
                seconds--;
            } else {
                seconds = 59;
                if (minutes > 0) {
                    minutes--;
                } else {
                    minutes = 59;
                    if (hours > 0) {
                        hours--;
                    } else {
                        retailTimer.innerHTML = "EXPIRED";
                        return;
                    }
                }
            }

            let displayH = hours < 10 ? '0' + hours : hours;
            let displayM = minutes < 10 ? '0' + minutes : minutes;
            let displayS = seconds < 10 ? '0' + seconds : seconds;

            retailTimer.innerHTML = `${displayH}:${displayM}:${displayS}`;
        }
        setInterval(startRetailTimer, 1000);
    }
});

/**
 * --- 2. UTILITY FUNCT: COPY PAYMENT CODE TO CLIPBOARD ---
 */
function copyPaymentCode() {
    const codeInput = document.getElementById('target-pay-code');
    if (codeInput) {
        codeInput.select();
        codeInput.setSelectionRange(0, 99999); // Untuk mobile browser safely

        navigator.clipboard.writeText(codeInput.value).then(() => {
            alert("Kode Pembayaran berhasil disalin: " + codeInput.value);
        }).catch(err => {
            console.error("Gagal menyalin kode: ", err);
        });
    }
}