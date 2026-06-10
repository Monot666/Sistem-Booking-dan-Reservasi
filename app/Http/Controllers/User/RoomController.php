<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Handles room browsing and search for the user-facing side.
 */
class RoomController extends Controller
{
    /**
     * Display available rooms with optional filters for capacity and availability.
     */
    public function index(Request $request)
    {
        $rooms = Room::where('is_active', true);

        // Filter by adult capacity
        if ($request->filled('adults')) {
            $rooms->where('max_adults', '>=', (int) $request->adults);
        }

        // Filter by children capacity
        if ($request->filled('children')) {
            $rooms->where('max_children', '>=', (int) $request->children);
        }

        // Fallback: filter by generic 'guests' field
        if (!$request->filled('adults') && !$request->filled('children') && $request->filled('guests')) {
            $rooms->where('capacity', '>=', (int) $request->guests);
        }

        // Filter by date availability (exclude rooms with conflicting bookings)
        if ($request->filled('checkin') && $request->filled('checkout')) {
            try {
                $checkin  = Carbon::parse($request->checkin)->startOfDay();
                $checkout = Carbon::parse($request->checkout)->endOfDay();

                $rooms->whereDoesntHave('bookings', function ($query) use ($checkin, $checkout) {
                    $query->where('status', '!=', 'cancelled')
                        ->where(function ($query) use ($checkin, $checkout) {
                            $query->where('start_time', '<', $checkout)
                                  ->where('end_time', '>', $checkin);
                        });
                });
            } catch (\Exception $e) {
                // Invalid date format — ignore availability filter
            }
        }

        return view('user.pilih-kamar', [
            'resources' => $rooms->get(),
            'checkin'   => $request->checkin,
            'checkout'  => $request->checkout,
            'guests'    => $request->guests,
            'rooms'     => $request->rooms,
        ]);
    }

    /**
     * Show a single room's details.
     */
    public function show(Room $room)
    {
        $user = auth()->user();

        $bookingData = [
            'room_title' => $room->name,
            'price'      => $room->price_per_hour,
            'tax'        => 0,
        ];

        return view('user.review-pemesanan', compact('room', 'user', 'bookingData'));
    }
}
