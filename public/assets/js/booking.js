document.addEventListener('DOMContentLoaded', function () {
    const bookingForm = document.querySelector('.booking-form');
    if (!bookingForm) {
        return;
    }

    bookingForm.addEventListener('submit', function () {
        const submitButton = bookingForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerText = 'Memproses...';
        }
    });
});
