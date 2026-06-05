/**
 * Logika SPA & Interaksi Multi-Upload Content Creator
 */

// Fungsi untuk menyesuaikan layout berdasarkan jumlah gambar yang diterima
function showEditLayout(layoutName, mockupUrl, ad1Url, ad2Url = '', ad3Url = '') {
    // Tampilkan panel upload
    document.getElementById('view-selection').style.display = 'none';
    document.getElementById('view-upload').style.display = 'block';
    
    document.getElementById('selected-layout-title').innerText = layoutName;
    document.getElementById('mockup-image').src = mockupUrl;

    // --- BLOK 1 (Selalu Muncul) ---
    document.getElementById('upload-block-1').style.display = 'block';
    document.getElementById('current-ad-image-1').src = ad1Url;

    // Sembunyikan semua input link secara default
    document.getElementById('link-group-1').style.display = 'none';
    document.getElementById('link-group-2').style.display = 'none';
    document.getElementById('link-group-3').style.display = 'none';

    // --- LOGIKA KONDISIONAL ---
    if (layoutName === 'Dashboard Explore') {
        // Tampilkan 3 Blok & 3 Input Link
        document.getElementById('upload-block-2').style.display = 'block';
        document.getElementById('upload-block-3').style.display = 'block';
        
        document.getElementById('current-ad-image-2').src = ad2Url;
        document.getElementById('current-ad-image-3').src = ad3Url;

        document.getElementById('link-group-1').style.display = 'block';
        document.getElementById('link-group-2').style.display = 'block';
        document.getElementById('link-group-3').style.display = 'block';

    } else if (layoutName === 'Pembayaran') {
        // Tampilkan 2 Blok (Tanpa Input Link)
        document.getElementById('upload-block-2').style.display = 'block';
        document.getElementById('upload-block-3').style.display = 'none'; // Sembunyikan blok 3
        
        document.getElementById('current-ad-image-2').src = ad2Url;

    } else {
        // Tampilkan 1 Blok saja
        document.getElementById('upload-block-2').style.display = 'none';
        document.getElementById('upload-block-3').style.display = 'none';
    }
}

function showLayoutSelection() {
    document.getElementById('view-selection').style.display = 'block';
    document.getElementById('view-upload').style.display = 'none';
}

// Inisialisasi Dropzone
document.addEventListener("DOMContentLoaded", function() {
    
    // Fungsi untuk menghubungkan area dropzone dengan input filenya
    function setupDropZone(zoneId, inputId) {
        const dropZone = document.getElementById(zoneId);
        const fileInput = document.getElementById(inputId);

        if(!dropZone || !fileInput) return; // Mencegah error jika elemen tidak ada

        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                updateThumbnail(dropZone, fileInput.files[0]);
            }
        });
    }

    // Aktifkan ketiga dropzone
    setupDropZone('drop-zone-1', 'file-input-1');
    setupDropZone('drop-zone-2', 'file-input-2');
    setupDropZone('drop-zone-3', 'file-input-3');

    // Tombol Submit Global
    const btnUpload = document.getElementById('btn-upload');
    btnUpload.addEventListener('click', () => {
        const originalText = btnUpload.innerHTML;
        btnUpload.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan Perubahan...';
        btnUpload.disabled = true;

        setTimeout(() => {
            alert('Semua pembaruan untuk layout ' + document.getElementById('selected-layout-title').innerText + ' berhasil disimpan dan diperbarui ke sistem pengguna!');
            btnUpload.innerHTML = originalText;
            btnUpload.disabled = false;
            showLayoutSelection(); 
        }, 1500);
    });

    // Menampilkan Preview di dalam kotak putus-putus
    function updateThumbnail(dropZone, file) {
        let thumbnailElement = dropZone.querySelector(".drop-zone__thumb");
        let content = dropZone.querySelector(".drop-zone-content");

        if (content) {
            content.style.display = "none";
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

        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => {
            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
        };
    }
});