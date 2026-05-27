<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roomly Admin</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f9fd] flex">

    <aside class="w-72 bg-[#0a0a0a] min-h-screen text-white p-6 fixed">
        <div class="flex items-center mb-10">
            <img src="{{ asset('assets/img/icons/logo.svg') }}" alt="Logo" class="w-8 mr-2">
            <span class="text-xl font-bold">Roomly Admin</span>
        </div>

        <nav class="space-y-4">
            <a href="#" class="flex items-center p-3 bg-[#e6a04d] rounded-xl text-black font-bold">
                <i class="fa-solid fa-table-columns mr-4"></i> Dashboard
            </a>
            <a href="#" class="flex items-center p-3 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-bed mr-4"></i> Rooms
            </a>
            <a href="#" class="flex items-center p-3 text-gray-400 hover:text-white transition">
                <i class="fa-solid fa-calendar-days mr-4"></i> Bookings
            </a>
            </nav>
    </aside>

    <main class="flex-1 ml-72 p-10">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>