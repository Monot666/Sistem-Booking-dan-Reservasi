document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('guestSearch');
    const guestItems = document.querySelectorAll('.guest-item');

    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            // Ambil teks yang diketik pengguna (ubah ke huruf kecil agar pencarian tidak sensitif besar/kecil huruf)
            const searchTerm = e.target.value.toLowerCase();

            guestItems.forEach(function(item) {
                // Ambil data nama, email, dan telepon dari dalam masing-masing kartu
                const name = item.querySelector('.guest-name').textContent.toLowerCase();
                const email = item.querySelector('.guest-email span').textContent.toLowerCase();
                const phone = item.querySelector('.guest-phone span').textContent.toLowerCase();

                // Cek apakah ada kecocokan teks
                if (name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm)) {
                    item.style.display = 'block'; // Tampilkan kartu jika cocok
                } else {
                    item.style.display = 'none'; // Sembunyikan kartu jika tidak cocok
                }
            });
        });
    }
});