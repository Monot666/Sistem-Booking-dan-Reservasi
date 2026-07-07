/**
 * Logika SPA & Interaksi Multi-Upload Content Creator
 */

// Fungsi untuk menyesuaikan layout berdasarkan jumlah gambar yang diterima
window.showEditLayout = function showEditLayout(layoutName, mockupUrl, ad1Url, ad1Link = '', ad2Url = '', ad2Link = '', ad3Url = '', ad3Link = '', ad4Url = '', ad4Link = '') {
    // Tampilkan panel upload
    document.getElementById('view-selection').style.display = 'none';
    document.getElementById('view-upload').style.display = 'block';

    document.getElementById('selected-layout-title').innerText = layoutName;
    document.getElementById('mockup-image').src = mockupUrl;



    let ads = [
        { url: ad1Url, link: ad1Link },
        { url: ad2Url, link: ad2Link },
        { url: ad3Url, link: ad3Link },
        { url: ad4Url, link: ad4Link }
    ];

    // Reset state (blok upload & visibility)
    for(let i=1; i<=4; i++) {
        if(document.getElementById('upload-block-' + i)) {
            document.getElementById('upload-block-' + i).style.display = 'none';
            document.getElementById('current-ad-image-' + i).parentElement.style.display = 'block';
            if(document.getElementById('drop-zone-' + i)) document.getElementById('drop-zone-' + i).style.display = 'block';
        }
        if(document.getElementById('delete-flag-' + i)) document.getElementById('delete-flag-' + i).value = '0';
        if(document.getElementById('link-group-' + i)) document.getElementById('link-group-' + i).style.display = 'none';
    }

    // Helper per slot
    function applySlot(i, ad, { showLinkAlways = false } = {}) {
        document.getElementById('upload-block-' + i).style.display = 'block';

        if (ad.url && ad.url !== '') {
            document.getElementById('current-ad-image-' + i).src = ad.url;
            document.getElementById('current-ad-image-' + i).parentElement.style.display = 'block';

            document.getElementById('link-input-' + i).value = ad.link;
            document.getElementById('link-group-' + i).style.display = 'block';

            if(document.getElementById('drop-zone-' + i)) document.getElementById('drop-zone-' + i).style.display = 'none';
        } else {
            document.getElementById('current-ad-image-' + i).parentElement.style.display = 'none';
            document.getElementById('link-input-' + i).value = '';

            // Link "selalu tampil" untuk kebutuhan layout tertentu
            if (showLinkAlways) {
                document.getElementById('link-group-' + i).style.display = 'block';
            } else {
                document.getElementById('link-group-' + i).style.display = 'none';
            }

            if(document.getElementById('drop-zone-' + i)) document.getElementById('drop-zone-' + i).style.display = 'block';
        }
    }

    // --- LOGIKA TAMPILAN SLOT ---
    if (layoutName === 'Dashboard Explore') {
        // Tampilkan Foto 1-3, link mengikuti aturan existing (tidak selalu)
        for (let i = 1; i <= 3; i++) {
            applySlot(i, ads[i-1], { showLinkAlways: false });
        }
    } else if (layoutName === 'Fasilitas Hotel') {
        // Tampilkan Foto 1-4, link harus tampil juga walau belum ada foto
        for (let i = 1; i <= 4; i++) {
            applySlot(i, ads[i-1], { showLinkAlways: true });
        }
    } else if (layoutName === 'Pembayaran') {
        for (let i = 1; i <= 2; i++) {
            document.getElementById('upload-block-' + i).style.display = 'block';
            document.getElementById('current-ad-image-' + i).src = ads[i-1].url || '/assets/img/content_creator/ad.jpg';
            document.getElementById('link-group-' + i).style.display = 'block';
            document.getElementById('link-input-' + i).value = ads[i-1].link || '';
        }
    } else {
    document.getElementById('upload-block-1').style.display = 'block';
        document.getElementById('current-ad-image-1').src = ads[0].url || '';
        document.getElementById('link-group-1').style.display = 'block';
        document.getElementById('link-input-1').value = ads[0].link || '';

        // Pastikan Foto 1 terlihat sebagai kosong jika belum ada URL tersimpan
        if(!ads[0].url){
            document.getElementById('current-ad-image-1').parentElement.style.display = 'none';
            if(document.getElementById('drop-zone-1')) document.getElementById('drop-zone-1').style.display = 'block';
        }

        // Jangan auto tampilkan gambar default kalau tidak ada foto tersimpan
        if(!ads[0].url){
            document.getElementById('current-ad-image-1').src = '';
            document.getElementById('current-ad-image-1').parentElement.style.display = 'none';
            if(document.getElementById('drop-zone-1')) document.getElementById('drop-zone-1').style.display = 'block';
        }
    }
}

window.showLayoutSelection = function showLayoutSelection() {
    document.getElementById('view-selection').style.display = 'block';
    document.getElementById('view-upload').style.display = 'none';
}

// Fungsi menghapus foto dari UI sebelum disubmit
window.deleteAd = function deleteAd(index) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Foto ' + index + ' akan dihapus dari layout ini.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('current-ad-image-' + index).src = '';
            if(document.getElementById('link-input-' + index)) document.getElementById('link-input-' + index).value = '';
            if(document.getElementById('file-input-' + index)) document.getElementById('file-input-' + index).value = '';
            if(document.getElementById('delete-flag-' + index)) document.getElementById('delete-flag-' + index).value = '1';
            
            // Langsung trigger simpan agar real-time dan tersinkronisasi dengan database!
            document.getElementById('btn-upload').click();
        }
    });
}

// Inisialisasi Dropzone
document.addEventListener("DOMContentLoaded", function() {
    
    // Fungsi untuk menghubungkan area dropzone dengan input filenya
    function setupDropZone(zoneId, inputId, index) {
        const dropZone = document.getElementById(zoneId);
        const fileInput = document.getElementById(inputId);

        if(!dropZone || !fileInput) return; // Mencegah error jika elemen tidak ada

        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener("change", (e) => {
            if (fileInput.files.length) {
                if (typeof updateThumbnail === 'function') {
                    updateThumbnail(dropZone, fileInput.files[0]);
                }
                
                // Update preview gambar di atas (jika sedang ganti foto)
                const currentImg = document.getElementById('current-ad-image-' + index);
                if (currentImg && currentImg.parentElement.style.display !== 'none') {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        currentImg.src = e.target.result;
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                } else if (currentImg) {
                    // Jika sebelumnya kosong, munculkan area current photo dan sembunyikan drop zone
                    currentImg.parentElement.style.display = 'block';
                    document.getElementById('drop-zone-' + index).style.display = 'none';
                    document.getElementById('link-group-' + index).style.display = 'block';
                    
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        currentImg.src = e.target.result;
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        });
    }

    // Aktifkan ketiga dropzone
    setupDropZone('drop-zone-1', 'file-input-1', 1);
    setupDropZone('drop-zone-2', 'file-input-2', 2);
    setupDropZone('drop-zone-3', 'file-input-3', 3);
    setupDropZone('drop-zone-4', 'file-input-4', 4);

    // Tombol Submit Global
    const btnUpload = document.getElementById('btn-upload');
    btnUpload.addEventListener('click', () => {
        const originalText = btnUpload.innerHTML;
        btnUpload.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan Perubahan...';
        btnUpload.disabled = true;

        const formData = new FormData();
        formData.append('layout_name', document.getElementById('selected-layout-title').innerText);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        if (document.getElementById('file-input-1').files[0]) formData.append('file_1', document.getElementById('file-input-1').files[0]);
        if (document.getElementById('link-input-1')) formData.append('link_1', document.getElementById('link-input-1').value);
        if (document.getElementById('delete-flag-1')) formData.append('delete_1', document.getElementById('delete-flag-1').value);
        
        if (document.getElementById('file-input-2') && document.getElementById('file-input-2').files[0]) formData.append('file_2', document.getElementById('file-input-2').files[0]);
        if (document.getElementById('link-input-2')) formData.append('link_2', document.getElementById('link-input-2').value);
        if (document.getElementById('delete-flag-2')) formData.append('delete_2', document.getElementById('delete-flag-2').value);
        
        if (document.getElementById('file-input-3') && document.getElementById('file-input-3').files[0]) formData.append('file_3', document.getElementById('file-input-3').files[0]);
        if (document.getElementById('link-input-3')) formData.append('link_3', document.getElementById('link-input-3').value);
        if (document.getElementById('delete-flag-3')) formData.append('delete_3', document.getElementById('delete-flag-3').value);

        if (document.getElementById('file-input-4') && document.getElementById('file-input-4').files[0]) formData.append('file_4', document.getElementById('file-input-4').files[0]);
        if (document.getElementById('link-input-4')) formData.append('link_4', document.getElementById('link-input-4').value);
        if (document.getElementById('delete-flag-4')) formData.append('delete_4', document.getElementById('delete-flag-4').value);

        fetch('/content/upload', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            // Muat ulang halaman agar mendapatkan url foto terbaru dari database (tidak stale)
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengunggah gambar.');
            btnUpload.innerHTML = originalText;
            btnUpload.disabled = false;
        });
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