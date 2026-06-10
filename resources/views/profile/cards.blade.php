@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kartu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endpush

@section('content')
<div class="container-fluid px-4 px-lg-5 py-4" style="max-width: 1440px;">
    
    <div class="profile-page-title mb-4">
        <a href="{{ route('home') }}"><i class="fa-solid fa-angle-left"></i></a>
        <h2>Kartu Saya</h2>
    </div>

    <div class="row g-4">
        <div class="col-md-4 col-lg-3">
            @include('layouts.sidebar_profile')
        </div>

        <div class="col-md-8 col-lg-9">
            <div class="profile-card form-content-area">
                <h4 class="section-title">Daftar Kartu Debit / Kredit</h4>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row g-3">
                    @foreach($cards as $card)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card-item card-filled p-3" onclick="openEditModal({{ $card->id }}, '{{ $card->bank_name }}', '{{ $card->account_number }}', '{{ $card->card_name }}')" style="cursor: pointer; border: 1px solid #e2e8f0; border-radius: 8px; height: 100%; min-height: 120px;">
                            <div class="bank-logo-wrapper mb-2">
                                <img src="{{ asset('assets/img/banks/' . strtolower(str_replace(' ', '_', $card->bank_name)) . '.png') }}" alt="{{ $card->bank_name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" style="height: 20px;">
                                <span class="bank-name-fallback fw-bold text-primary" style="display:none; font-size:14px;">{{ strtoupper($card->bank_name) }}</span>
                            </div>
                            <div class="card-holder-name fw-bold mt-2" style="font-size: 0.9rem;">{{ $card->card_name }}</div>
                            <div class="card-number text-muted small">{{ $card->account_number }}</div>
                        </div>
                    </div>
                    @endforeach

                    @for ($i = count($cards); $i < 3; $i++)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card-item card-add" onclick="openAddModal()" style="cursor: pointer; border: 2px dashed #e2e8f0; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; min-height: 120px; border-radius: 8px; color: #df9e38;">
                            <div class="add-icon"><i class="fas fa-plus-circle mb-2" style="font-size: 1.5rem;"></i></div>
                            <div class="add-label" style="font-size: 0.85rem; font-weight: 500;">Tambah Kartu</div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Tambah Kartu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.cards.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="text" name="bank_name" class="form-control custom-input mb-3" placeholder="Nama Bank di Kartu" required>
                    <input type="text" name="account_number" class="form-control custom-input mb-3" placeholder="Nomor Rekening Kartu" required>
                    <input type="text" name="card_name" class="form-control custom-input mb-4" placeholder="Nama yang tertera di kartu" required>
                    <button type="submit" class="btn btn-save w-100 m-0">Tambah Kartu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Edit Kartu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCardForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" id="edit_bank_name" name="bank_name" class="form-control custom-input mb-3" required>
                    <input type="text" id="edit_account_number" name="account_number" class="form-control custom-input mb-3" required>
                    <input type="text" id="edit_card_name" name="card_name" class="form-control custom-input mb-4" required>
                    <button type="submit" class="btn btn-save w-100 m-0 mb-2">Simpan Perubahan</button>
                </form>
                <form id="deleteCardForm" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kartu ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100 border-0" style="border-radius: 6px; padding: 10px;">Hapus Kartu</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/cards.js') }}"></script>
@endpush