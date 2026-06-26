// ==========================================================================
// PAYMENT PAGE INTERACTIVE LOGIC (COUNTDOWN + ACCORDION) - ROOMLY
// ==========================================================================

document.addEventListener("DOMContentLoaded", function () {

    // --- 1. LOGIKA COUNTDOWN TIMER ---
    let totalSeconds = (30 * 60); // 1 jam
    const timerElement = document.getElementById('countdown-timer');

    if (timerElement) {
        function updateCountdown() {
            let minutes = Math.floor(totalSeconds / 60);
            let seconds = totalSeconds % 60;

            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            timerElement.innerHTML = `00:${minutes}:${seconds}`;

            if (totalSeconds > 0) {
                totalSeconds--;
            } else {
                clearInterval(timerInterval);
                timerElement.innerHTML = "WAKTU HABIS";
                alert("Waktu pembayaran telah habis. Silakan lakukan pemesanan ulang.");

                const redirectUrl = timerElement.getAttribute('data-redirect');
                window.location.href = redirectUrl ? redirectUrl : '/booking';
            }
        }
        updateCountdown();
        let timerInterval = setInterval(updateCountdown, 1000);
    }

    // --- 2. LOGIKA INTERAKTIF ACCORDION METODE PEMBAYARAN ---
    const accordionHeaders = document.querySelectorAll('.payment-header-trigger');

    accordionHeaders.forEach(header => {
        header.addEventListener('click', function () {
            const currentGroup = this.parentElement;
            const currentContent = currentGroup.querySelector('.payment-dropdown-content');
            const currentRadio = this.querySelector('.parent-radio');

            const isAlreadyActive = currentGroup.classList.contains('active');

            // Tutup semua grup akordion yang sedang terbuka
            document.querySelectorAll('.payment-group-item').forEach(group => {
                group.classList.remove('active');
                const content = group.querySelector('.payment-dropdown-content');
                if (content) content.style.display = 'none';
            });

            // Jika yang diklik belum aktif, buka dropdown-nya
            if (!isAlreadyActive) {
                currentGroup.classList.add('active');
                if (currentContent) currentContent.style.display = 'block';
                if (currentRadio) currentRadio.checked = true;
            }
        });
    });
});

/**
 * --- 3. FUNGSI UTILITY: MENYALIN NOMOR REKENING ---
 */
function copyAccountNumber() {
    const accountInput = document.getElementById('rekening-number');
    if (accountInput) {
        accountInput.select();
        accountInput.setSelectionRange(0, 99999);

        navigator.clipboard.writeText(accountInput.value).then(() => {
            alert("Nomor rekening berhasil disalin: " + accountInput.value);
        }).catch(err => {
            console.error('Gagal menyalin teks: ', err);
        });
    }
}