<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header border-0">
                <h5 class="fw-bold mb-0">Tambah E-Wallet</h5>
                <span onclick="closeModal()" class="close-btn" style="cursor: pointer;">&times;</span>
            </div>
            <form action="{{ route('profile.ewallet.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="text" name="name" placeholder="Nama E-Wallet (cth: GoPay)" class="form-control mb-3" required>
                    <input type="text" name="phone" placeholder="Nomor Handphone" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-warning w-100">Tambah E-Wallet</button>
                </div>
            </form>
        </div>
    </div>
</div>