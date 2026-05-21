<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ResourceController extends Controller {
    public function index(Request $request) { 
        $resources = Resource::where('is_active', true);

        if ($request->filled('guests')) {
            $resources->where('capacity', '>=', (int) $request->guests);
        }

        if ($request->filled('checkin') && $request->filled('checkout')) {
            try {
                $checkin = Carbon::parse($request->checkin)->startOfDay();
                $checkout = Carbon::parse($request->checkout)->endOfDay();

                $resources->whereDoesntHave('bookings', function ($query) use ($checkin, $checkout) {
                    $query->where('status', '!=', 'cancelled')
                        ->where(function ($query) use ($checkin, $checkout) {
                            $query->where('start_time', '<', $checkout)
                                  ->where('end_time', '>', $checkin);
                        });
                });
            } catch (\Exception $e) {
                // invalid date format, ignore availability filter
            }
        }

        $resources = $resources->get();

        // UI booking flow: tampilkan halaman pilih kamar (pilih-kamar.blade.php)
        // kalau perlu data resources, kirimkan sebagai variabel.
        return view('user.pilih-kamar', [
            'resources' => $resources,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'guests' => $request->guests,
            'rooms' => $request->rooms,
        ]);

    }

    public function show(Resource $resource) { 
        $user = auth()->user();

        // Minimal data agar view "Review Pemesanan" tidak error.
        // Sesuaikan tax/price jika nanti sudah ada perhitungan real dari booking.
        $bookingData = [
            'room_title' => $resource->name,
            'price' => $resource->price_per_hour,
            'tax' => 0,
        ];

        return view('user.review-pemesanan', compact('resource', 'user', 'bookingData'));
    }


    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'capacity' => 'required|integer',
            'price_per_hour' => 'required|numeric',
        ]);
        
        $resource = Resource::create($data);
        
        return response()->json([
            'message' => 'Resource created successfully',
            'data' => $resource
        ], 201);
    }

    public function update(Request $request, Resource $resource) {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'type' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'capacity' => 'sometimes|required|integer',
            'price_per_hour' => 'sometimes|required|numeric',
        ]);
        
        $resource->update($data);
        
        return response()->json([
            'message' => 'Resource updated successfully',
            'data' => $resource
        ], 200);
    }

    public function destroy(Resource $resource) {
        $resource->delete();
        
        return response()->json([
            'message' => 'Resource deleted successfully'
        ], 200);
    }
}
