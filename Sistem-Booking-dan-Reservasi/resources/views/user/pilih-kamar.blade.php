<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kamar</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans antialiased">

    <!-- HEADER -->
    <div class="bg-[#e69c24] text-white p-4 flex items-center gap-4">

        <a href="{{ url()->previous() }}"
           class="text-xl hover:opacity-80">
            <i class="fa-solid fa-chevron-left"></i>
        </a>

        <h1 class="text-lg font-bold">
            Pilih Kamar
        </h1>

    </div>

    <!-- CONTENT -->
    <div class="max-w-6xl mx-auto p-6">

        <!-- INFO BOOKING -->
        <div class="bg-white rounded-xl shadow-sm p-5 mb-6">

            <div class="grid md:grid-cols-4 gap-4 text-sm">

                <div>
                    <p class="text-gray-400">Checkin</p>
                    <h3 class="font-bold">
                        {{ $checkin ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-gray-400">Checkout</p>
                    <h3 class="font-bold">
                        {{ $checkout ?? '-' }}
                    </h3>
                </div>

                <div>
                    <p class="text-gray-400">Guests</p>
                    <h3 class="font-bold">
                        {{ $guests ?? 0 }} Orang
                    </h3>
                </div>

                <div>
                    <p class="text-gray-400">Rooms</p>
                    <h3 class="font-bold">
                        {{ $rooms ?? 0 }} Kamar
                    </h3>
                </div>

            </div>

        </div>

        <!-- DATA KAMAR -->
        @forelse($resources as $resource)

        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm mb-6">

            <div class="flex flex-col lg:flex-row gap-6">

                <!-- GAMBAR -->
                <div class="w-full lg:w-1/3">

                    <img src="{{ $resource->image }}"
                         alt="{{ $resource->name }}"
                         class="w-full h-64 object-cover rounded-xl">

                </div>

                <!-- DETAIL -->
                <div class="w-full lg:w-2/3 flex flex-col justify-between">

                    <div>

                        <h2 class="text-2xl font-bold text-[#e69c24] mb-2">
                            {{ $resource->name }}
                        </h2>

                        <p class="text-gray-500 mb-4">
                            {{ $resource->description }}
                        </p>

                        <div class="grid grid-cols-2 gap-4 text-sm text-gray-600 mb-5">

                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-user-group text-[#e69c24]"></i>
                                Kapasitas {{ $resource->capacity }} Orang
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-bed text-[#e69c24]"></i>
                                {{ $resource->type }}
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-wifi text-[#e69c24]"></i>
                                WiFi Gratis
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-snowflake text-[#e69c24]"></i>
                                AC
                            </div>

                        </div>

                    </div>

                    <!-- HARGA -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>

                            <p class="text-gray-400 text-sm">
                                Harga / malam
                            </p>

                            <h3 class="text-3xl font-bold text-[#e69c24]">
                                Rp {{ number_format($resource->price_per_hour, 0, ',', '.') }}
                            </h3>

                        </div>

                        <a href="{{ route('pilih-kamar.show', $resource->id) }}"
                           class="bg-[#e69c24] hover:bg-[#cc851a] transition text-white px-6 py-3 rounded-lg text-center font-semibold">

                            Pilih Kamar

                        </a>

                    </div>

                </div>

            </div>

        </div>

        @empty

        <!-- JIKA TIDAK ADA KAMAR -->
        <div class="bg-white rounded-xl shadow-sm p-10 text-center">

            <i class="fa-solid fa-bed text-5xl text-gray-300 mb-4"></i>

            <h2 class="text-xl font-bold text-gray-700 mb-2">
                Kamar Tidak Tersedia
            </h2>

            <p class="text-gray-500">
                Tidak ada kamar yang tersedia untuk tanggal tersebut.
            </p>

        </div>

        @endforelse

    </div>

</body>
</html>