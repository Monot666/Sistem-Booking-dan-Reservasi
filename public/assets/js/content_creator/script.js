/**
 * Logika SPA & Interaksi Dropzone Content Creator Portal
 */

// Fungsi berpindah ke halaman detail upload dan MENGUBAH FOTO MOCKUP
function showEditLayout(layoutName, imageUrl) {
    // Sembunyikan grid, tampilkan form upload
    document.getElementById('view-selection').style.display = 'none';
    document.getElementById('view-upload').style.display = 'block';
    
    // Sesuaikan judul dengan layout yang diklik
    document.getElementById('selected-layout-title').innerText = layoutName;
    document.getElementById('span-layout-name').innerText = layoutName.toLowerCase();

    // Ganti gambar mockup di halaman upload sesuai dengan gambar kartu yang diklik
    document.getElementById('mockup-image').src = imageUrl;
}

// Fungsi kembali ke pemilihan awal
function showLayoutSelection() {
    // Sembunyikan form upload, tampilkan kembali grid
    document.getElementById('view-selection').style.display = 'block';
    document.getElementById('view-upload').style.display = 'none';
}

// Logika Drag, Drop, & Preview Gambar
document.addEventListener("DOMContentLoaded", function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const btnUpload = document.getElementById('btn-upload');

    // Trigger klik input file saat kotak putus-putus diklik
    dropZone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) {
            updateThumbnail(dropZone, fileInput.files[0]);
        }
    });

    // Simulasi tombol Upload
    btnUpload.addEventListener('click', () => {
        if (!fileInput.files.length) {
            alert('Silakan pilih file gambar terlebih dahulu!');
            return;
        }
        
        // Animasi loading
        const originalText = btnUpload.innerHTML;
        btnUpload.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengunggah...';
        btnUpload.disabled = true;

        setTimeout(() => {
            alert('Banner untuk ' + document.getElementById('selected-layout-title').innerText + ' berhasil diperbarui!');
            btnUpload.innerHTML = originalText;
            btnUpload.disabled = false;
            
            // Opsional: Kembali ke menu awal setelah sukses upload
            showLayoutSelection(); 
        }, 1500);
    });

    // Fungsi menampilkan preview gambar di dalam dropzone
    function updateThumbnail(dropZone, file) {
        let thumbnailElement = dropZone.querySelector(".drop-zone__thumb");

        // Hapus ikon dan teks placeholder
        if (dropZone.querySelector(".drop-zone-content")) {
            dropZone.querySelector(".drop-zone-content").style.display = "none";
        }

        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            thumbnailElement.style.width = "100%";
            thumbnailElement.style.height = "100%";
            thumbnailElement.style.borderRadius = "8px";
            thumbnailElement.style.backgroundSize = "cover";
            thumbnailElement.style.backgroundPosition = "center";
            dropZone.appendChild(thumbnailElement);
        }

        // Tampilkan gambar menggunakan FileReader
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    }
});