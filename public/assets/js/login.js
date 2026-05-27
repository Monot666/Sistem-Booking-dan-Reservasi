/* public/assets/js/login.js */

document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    // Pastikan elemen ada sebelum menjalankan script
    if (eyeIcon && passwordInput) {
        eyeIcon.addEventListener('click', function () {
            // Toggle tipe input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon class (mata terbuka / mata tertutup)
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
});