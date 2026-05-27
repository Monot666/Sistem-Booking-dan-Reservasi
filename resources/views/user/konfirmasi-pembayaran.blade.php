@extends('layouts.app')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="bg-white border-b border-gray-200 p-4 sticky top-0 z-40">
    <div class="max-w-6xl mx-auto flex items-center gap-3">
        <a href="{{ url('/') }}" class="text-[#e69c24] text-xl font-bold hover:opacity-80">
            <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-xl font-bold text-gray-800">Pembayaran</h1>
    </div>
</div>

<div class="max-w-6xl mx-auto p-4 md:p-6">
    @if($status === 'pending')
        <div class="bg-[#e69c24] text-white text-center rounded-t-xl p-3 text-xs md:text-sm font-medium shadow-sm">
            Tenang, harganya tidak akan berubah. Yuk selesaikan pembayaran dalam <span class="font-bold">00:15:20</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-0">
        
        <div class="lg:col-span-2 space-y-4">
            
            @if($status === 'success')
                <div class="bg-white border border-gray-200 rounded-xl p-8 text-center shadow-sm flex flex-col items-center justify-center min-h-[250px]">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-md mb-4 animate-bounce">
                        ✓
                    </div>
                    <h2 class="text-xl md:text-2xl font-black text-gray-800 mb-1">Pembelian Berhasil</h2>
                    <p class="text-xs md:text-sm text-gray-500 font-medium">Rab, 11 Maret 2026</p>
                </div>

                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 rounded-xl p-6 text-white shadow-md relative overflow-hidden flex items-center min-h-[120px]">
                    <div class="z-10 max-w-md">
                        <h3 class="text-xl font-black tracking-wide uppercase leading-tight drop-shadow-sm">
                            Saat Demam,<br>Jaga Cairan Tubuh
                        </h3>
                    </div>
                    <div class="absolute right-[-20px] bottom-[-30px] w-44 h-44 bg-white/10 rounded-full blur-xl"></div>
                    <div class="absolute right-4 text-5xl opacity-20">💧</div>
                </div>

                <div class="pt-2">
                    <a href="{{ url('/') }}" class="block text-center w-full bg-[#e69c24] text-white font-bold py-3 px-4 rounded-xl shadow-md hover:bg-[#cc851a] transition text-sm">
                        Kembali ke Beranda
                    </a>
                </div>

            @else
                <div class="bg-white rounded-b-xl border-x border-b border-gray-200 p-5 shadow-sm space-y-5">
                    
                    @if($bank === 'minimarket')
                        <h3 class="font-bold text-gray-700 text-sm">Tunjukkan kode ini kepada kasir</h3>
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center">
                            <span class="font-mono font-black text-2xl md:text-3xl tracking-widest text-gray-800 block">2101000012345678</span>
                        </div>
                    @else
                        <h3 class="font-bold text-gray-700 text-sm">Mohon Transfer ke</h3>
                        
                        <div class="border border-gray-200 rounded-xl overflow-hidden text-xs md:text-sm">
                            <div class="bg-blue-100/50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                                <span class="font-bold text-gray-800">{{ strtoupper($bank) }} Virtual Account</span>
                                <span class="font-black italic text-blue-700 text-xs">{{ strtoupper($bank) }}</span>
                            </div>
                            
                            <div class="p-4 space-y-3 bg-white">
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-gray-500">Nomor Rekening:</span>
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono font-bold text-gray-800 text-base">234567898765</span>
                                        <button class="text-[#e69c24] text-xs font-bold border border-gray-200 px-2 py-0.5 rounded shadow-sm bg-white hover:bg-gray-50">Salin</button>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center py-1 border-t border-gray-100">
                                    <span class="text-gray-500">Nama Penerima:</span>
                                    <span class="font-semibold text-gray-800 text-right">Roomly 12345678</span>
                                </div>
                                <div class="flex justify-between items-center py-1 border-t border-gray-100">
                                    <span class="text-gray-500">Jumlah Transfer:</span>
                                    <div class="flex items-center gap-2">
                                        <span class="font-extrabold text-gray-800 text-base">Rp 535.000</span>
                                        <button class="text-[#e69c24] text-xs font-bold border border-gray-200 px-2 py-0.5 rounded shadow-sm bg-white hover:bg-gray-50">Salin</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="space-y-2 pt-2" x-data="{ openGuide: 1 }">
                        <h4 class="font-bold text-gray-800 text-sm mb-3">How to Transfer</h4>
                        
                        @if($bank === 'minimarket')
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-xs text-gray-600 space-y-2 leading-relaxed">
                                <p>1. Tunjukkan kode unik/QR ke kasir.</p>
                                <p>2. Kasir akan menyebutkan nominal belanja dan nama pemilik akun.</p>
                                <p>3. Bayar sesuai nominal.</p>
                            </div>
                        @else
                            <div class="border border-gray-200 rounded-lg">
                                <button @click="openGuide = (openGuide === 1 ? 0 : 1)" class="w-full flex justify-between p-3.5 text-xs font-bold text-gray-700 bg-white items-center">
                                    <span>{{ $bank == 'bri' ? 'BRImo' : 'Mobile Banking' }}</span>
                                    <span class="text-gray-400" :class="openGuide === 1 ? 'rotate-180' : ''">▼</span>
                                </button>
                                <div class="p-4 bg-gray-50/50 border-t border-gray-100 text-xs text-gray-600 space-y-1" x-show="openGuide === 1" x-collapse>
                                    <p>1. Buka aplikasi M-Banking Anda.</p>
                                    <p>2. Pilih menu Transfer > Virtual Account.</p>
                                    <p>3. Masukkan nomor rekening di atas dan konfirmasi nominal.</p>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg">
                                <button @click="openGuide = (openGuide === 2 ? 0 : 2)" class="w-full flex justify-between p-3.5 text-xs font-bold text-gray-700 bg-white items-center">
                                    <span>ATM {{ strtoupper($bank) }}</span>
                                    <span class="text-gray-400" :class="openGuide === 2 ? 'rotate-180' : ''">▼</span>
                                </button>
                                <div class="p-4 bg-gray-50/50 border-t border-gray-100 text-xs text-gray-600 space-y-1" x-show="openGuide === 2" x-collapse>
                                    <p>1. Masukkan kartu ATM dan PIN.</p>
                                    <p>2. Pilih Transaksi Lain > Pembayaran > Virtual Account.</p>
                                    <p>3. Masukkan kode bayar lalu tekan Benar.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <form action="{{ route('payment.confirm') }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_method" value="va">
                            <input type="hidden" name="payment_bank" value="{{ $bank }}">
                            <input type="hidden" name="simulate_success" value="true">
                            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 px-4 rounded-xl shadow transition text-xs cursor-pointer">
                                🧪 Simulasi Bayar Sekarang (Ubah ke State Sukses)
                            </button>
                        </form>
                    </div>

                </div>
            @endif
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-[#e69c24] text-white p-4 flex items-center gap-3">
                    <span class="text-xl">🏢</span>
                    <div>
                        <h4 class="font-bold text-sm">@if($status === 'success') Rincian Hotel @else Rincian Pembayaran @endif</h4>
                        <p class="text-[11px] opacity-90">No. Pesanan 134567876</p>
                    </div>
                </div>
                <div class="p-5 space-y-4 text-xs text-gray-600">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Aston Hotel Solo</h3>
                        <p class="text-gray-500 mt-0.5">(1x) Superior Double - Room Only</p>
                    </div>
                    <div class="bg-amber-50/50 border border-amber-100 rounded-lg p-3 flex justify-between font-bold text-gray-800">
                        <div><span class="text-[10px] text-gray-400 block font-normal">Check-in</span>Kamis, 12 Mar 2026</div>
                        <span class="text-gray-300 flex items-center">➔</span>
                        <div class="text-right"><span class="text-[10px] text-gray-400 block font-normal">Check-out</span>Jumat, 13 Mar 2026</div>
                    </div>
                    <div class="space-y-1.5 border-b pb-3">
                        <p>👤 Dimas Sudarmono</p>
                        <p class="text-red-500">🚫 Tidak dapat di-refund</p>
                    </div>

                    @if($status === 'success')
                        <div class="space-y-2 border-b pb-3 text-gray-500">
                            <div class="flex justify-between"><span>Dibeli</span><span class="font-medium text-gray-800">Rab, 11 Maret 2026</span></div>
                            <div class="flex justify-between"><span>Metode</span><span class="font-medium text-gray-800">{{ strtoupper($bank) }}</span></div>
                        </div>
                    @endif

                    <div class="space-y-1.5 pt-1">
                        <div class="flex justify-between text-gray-400"><span>Harga Kamar</span><span class="font-semibold text-gray-700">Rp 445.000</span></div>
                        <div class="flex justify-between text-gray-400"><span>Pajak dan Biaya</span><span class="font-semibold text-gray-700">Rp 140.000</span></div>
                        <div class="flex justify-between text-red-500"><span>Kupon</span><span>-Rp 50.000</span></div>
                        <div class="flex justify-between items-center text-gray-800 font-bold text-sm pt-2 border-t border-dashed">
                            <span>Harga Total</span>
                            <span class="text-base font-black">Rp 535.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection