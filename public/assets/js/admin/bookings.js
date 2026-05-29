document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('bookingSearch');
    const statusFilter = document.getElementById('statusFilter');
    const bookingRows = document.querySelectorAll('.booking-row');

    // Fungsi utama untuk memfilter tabel
    function filterTable() {
        // Ambil nilai yang diketik/dipilih dan ubah ke huruf kecil
        const searchTerm = searchInput.value.toLowerCase();
        const filterStatus = statusFilter.value.toLowerCase();

        bookingRows.forEach(function(row) {
            // Ambil teks dari kolom Referensi, Nama Tamu, dan Atribut Data Status
            const ref = row.querySelector('.booking-ref').textContent.toLowerCase();
            const name = row.querySelector('.guest-name').textContent.toLowerCase();
            const status = row.querySelector('.booking-status').getAttribute('data-status').toLowerCase();

            // Cek kecocokan teks
            const matchesSearch = ref.includes(searchTerm) || name.includes(searchTerm);
            
            // Cek kecocokan status (Tampilkan jika filter adalah 'all' atau statusnya sama persis)
            const matchesStatus = filterStatus === 'all' || status === filterStatus;

            // Jika kedua kondisi terpenuhi, tampilkan baris. Jika tidak, sembunyikan.
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Jalankan fungsi setiap kali pengguna mengetik di kolom pencarian
    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }

    // Jalankan fungsi setiap kali pengguna mengubah pilihan dropdown
    if (statusFilter) {
        statusFilter.addEventListener('change', filterTable);
    }
});