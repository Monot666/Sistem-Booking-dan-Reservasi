@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/kartu.css') }}">
@endpush

@section('content')
<div class="container profile-container mt-4">
    <div class="row">

        {{-- ===================== SIDEBAR ===================== --}}
        <div class="col-md-3">
            @include('layouts.sidebar_profile')
        </div>

        {{-- ===================== MAIN CONTENT ===================== --}}
        <div class="col-md-9">
            <div class="glass-card p-4 shadow-sm">
                <h5 class="fw-bold mb-4">Kartu Saya</h5>

                {{-- Alert --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Card Grid --}}
                <div class="row g-3">

                    {{-- Existing Cards --}}
                    @foreach($cards as $card)
                    <div class="col-md-4">
                        <div class="card-item card-filled"
                             onclick="openEditModal({{ $card->id }}, '{{ $card->bank_name }}', '{{ $card->account_number }}', '{{ $card->card_name }}')"
                             style="cursor: pointer;">
                            <div class="bank-logo-wrapper mb-2">
                                <img src="{{ asset('assets/img/banks/' . strtolower(str_replace(' ', '_', $card->bank_name)) . '.png') }}"
                                     alt="{{ $card->bank_name }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <span class="bank-name-fallback fw-bold text-primary" style="display:none; font-size:14px;">
                                    {{ strtoupper($card->bank_name) }}
                                </span>
                            </div>
                            <div class="card-holder-name">{{ $card->card_name }}</div>
                            <div class="card-number text-muted small">{{ $card->account_number }}</div>
                        </div>
                    </div>
                    @endforeach

                    {{-- Tambah Kartu slots (fill remaining up to 3 visible slots) --}}
                    @for ($i = count($cards); $i < 3; $i++)
                    <div class="col-md-4">
                        <div class="card-item card-add" onclick="openAddModal()" style="cursor: pointer;">
                            <div class="add-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="add-label">Tambah Kartu</div>
                        </div>
                    </div>
                    @endfor

                    {{-- Extra Tambah Kartu if all 3 slots filled --}}
                    @if(count($cards) >= 3)
                    <div class="col-md-4">
                        <div class="card-item card-add" onclick="openAddModal()" style="cursor: pointer;">
                            <div class="add-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="add-label">Tambah Kartu</div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

{{-- ===================== MODAL TAMBAH KARTU ===================== --}}
<div class="modal fade" id="addCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-modal">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Kartu</h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times text-danger"></i>
                </button>
            </div>
            <div class="modal-body pt-2">
                <form action="{{ route('profile.cards.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama Bank</label>
                        <input type="text" name="bank_name" class="form-control input-custom"
                               placeholder="Nama Bank di Kartu" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nomor Rekening</label>
                        <input type="text" name="account_number" class="form-control input-custom"
                               placeholder="Nomor Rekening Kartu" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small text-muted">Nama di Kartu</label>
                        <input type="text" name="card_name" class="form-control input-custom"
                               placeholder="Nama yang tertera di kartu" required>
                    </div>
                    <button type="submit" class="btn btn-save w-100">Tambah Kartu</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ===================== MODAL EDIT KARTU ===================== --}}
<div class="modal fade" id="editCardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-modal">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Kartu</h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times text-danger"></i>
                </button>
            </div>
            <div class="modal-body pt-2">
                <form id="editCardForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nama Bank</label>
                        <input type="text" id="edit_bank_name" name="bank_name"
                               class="form-control input-custom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Nomor Rekening</label>
                        <input type="text" id="edit_account_number" name="account_number"
                               class="form-control input-custom" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small text-muted">Nama di Kartu</label>
                        <input type="text" id="edit_card_name" name="card_name"
                               class="form-control input-custom" required>
                    </div>
                    <button type="submit" class="btn btn-save w-100 mb-2">Simpan</button>
                </form>

                {{-- Delete Form --}}
                <form id="deleteCardForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100"
                            style="border-radius: 8px; font-weight: 600; padding: 10px;"
                            onclick="return confirm('Hapus kartu ini?')">
                        Hapus Kartu
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/cards.js') }}"></script>
@endpush