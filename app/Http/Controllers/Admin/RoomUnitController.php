<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomUnit;
use Carbon\Carbon;

class RoomUnitController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', \Carbon\Carbon::today()->format('Y-m-d'));

        // Fetch all room units with their parent room type and active/future bookings
        $roomUnits = RoomUnit::with(['room', 'bookings' => function($query) {
            $query->where('status', '!=', \App\Enums\BookingStatus::Cancelled)
                  ->whereDate('end_time', '>=', \Carbon\Carbon::today())
                  ->orderBy('start_time', 'asc');
        }])->get();
        
        // We evaluate the status dynamically for the given date
        foreach ($roomUnits as $unit) {
            $unit->is_booked = $unit->isBookedOn($date);
            if ($unit->is_booked) {
                $unit->active_booking = $unit->getActiveBookingOn($date);
            } else {
                $unit->active_booking = null;
            }
        }
        
        return view('admin.room_units', compact('roomUnits', 'date'));
    }
}
