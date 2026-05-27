@extends('layouts.sidebar_admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Rooms (Kamar)</h1>
            <p class="text-gray-400 text-sm">Kelola data kamar untuk ditampilkan ke user.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-600 text-white px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-xl bg-red-600 text-white px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form tambah resource --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm mb-6">
        <h2 class="text-lg font-bold mb-4">Tambah Kamar</h2>

        <form action="{{ route('resources.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" required class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#e69c24] focus:ring-[#e69c24] p-2">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe</label>
                    <input type="text" name="type" required class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#e69c24] focus:ring-[#e69c24] p-2">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kapasitas</label>
                    <input type="number" name="capacity" required class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#e69c24] focus:ring-[#e69c24] p-2">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Harga per jam</label>
                    <input type="number" name="price_per_hour" required step="0.01" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#e69c24] focus:ring-[#e69c24] p-2">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border-gray-200 shadow-sm focus:border-[#e69c24] focus:ring-[#e69c24] p-2"></textarea>
            </div>

            {{-- is_active disetel otomatis oleh backend jika ada default. Jika field di tabel wajib, kamu bisa tambah input berikut. --}}
            <div class="flex items-center gap-3 pt-1">
                <button type="submit" class="bg-[#e69c24] hover:bg-[#cc851a] transition text-white font-bold py-2 px-4 rounded-xl shadow">
                    Simpan
                </button>
                <button type="reset" class="bg-gray-100 hover:bg-gray-200 transition text-gray-800 font-semibold py-2 px-4 rounded-xl">
                    Reset
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm">
        <h2 class="text-lg font-bold mb-4">Daftar Kamar</h2>

        {{-- NOTE:
             Controller untuk admin rooms belum mengirim data $resources.
             Ini placeholder tampilan.
             Nanti setelah admin controller ditambahkan untuk CRUD, tabel ini akan diisi. --}}
        <div class="text-gray-500 text-sm">
            Tabel daftar resource akan tampil setelah endpoint admin rooms menyediakan data.
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // placeholder
    </script>
@endpush
