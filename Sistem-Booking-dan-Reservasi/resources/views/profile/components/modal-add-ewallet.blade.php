<form action="{{ route('profile.ewallet.store') }}" method="POST">

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">

            <div class="modal-header border-0">
                <h5 class="fw-bold">Tambah E-Wallet</h5>
                <span onclick="closeModal()" class="close-btn">×</span>
            </div>

            <div class="modal-body">
                <form action="#" method="POST">
                    @csrf

                    <input type="text" name="name" placeholder="Nama E-Wallet" class="form-control mb-3">
                    <input type="text" name="phone" placeholder="Nomor Handphone" class="form-control mb-3">

                    <button class="btn btn-warning w-100">Tambah E-Wallet</button>
                </form>
            </div>

        </div>
    </div>
</div>