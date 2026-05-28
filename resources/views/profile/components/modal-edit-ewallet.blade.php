<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header border-0">
                <h5 class="fw-bold mb-0">Edit E-Wallet</h5>
                <span onclick="closeEditModal()" class="close-btn" style="cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body text-center">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" id="edit_name" placeholder="Nama E-Wallet" class="form-control mb-2" required>
                    <input type="text" name="phone" id="edit_phone" placeholder="Nomor Handphone" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-warning w-100 mb-2">Simpan Perubahan</button>
                </form>
                <form id="deleteForm" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus e-wallet ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100 mb-2">Hapus E-Wallet</button>
                </form>
                <button type="button" class="btn btn-secondary w-100" onclick="closeEditModal()">Batal</button>
            </div>
        </div>
    </div>
</div>