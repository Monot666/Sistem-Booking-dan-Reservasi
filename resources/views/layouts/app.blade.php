<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Roomly - Luxury Hotel & Resort</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/booking2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pilih-kamar.css') }}">

    @stack('styles')
</head>
<body>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold mb-0">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body text-center pt-2 pb-4">
                    <i class="fa-solid fa-arrow-right-from-bracket mb-3" style="font-size: 3.5rem; color: #df9e38;"></i>
                    <p class="mb-0" style="font-size: 1.1rem; color: #4b5563;">Apakah Anda yakin ingin logout?</p>
                </div>
                
                <div class="modal-footer border-0 pt-0 d-flex justify-content-center gap-2 pb-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius: 6px; font-weight: 500;">Batal</button>
                    
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn px-4" style="background-color: #ef4444; color: white; border-radius: 6px; font-weight: 500;">Ya, Keluar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>