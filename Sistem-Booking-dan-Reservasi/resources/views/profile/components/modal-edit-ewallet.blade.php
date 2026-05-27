<form id="editForm" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" id="edit_name" class="form-control mb-2">
    <input type="text" name="phone" id="edit_phone" class="form-control mb-3">

    <button class="btn btn-warning w-100 mb-2">Simpan</button>
</form>

<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">

            <div class="modal-header border-0">
                <h5 class="fw-bold">Edit E-Wallet</h5>
                <span onclick="closeEditModal()" class="close-btn">×</span>
            </div>

            <div class="modal-body text-center">

                <button class="btn btn-warning w-100 mb-2">Batal</button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger w-100">Hapus E-Wallet</button>
                </form>

            </div>

        </div>
    </div>
</div>