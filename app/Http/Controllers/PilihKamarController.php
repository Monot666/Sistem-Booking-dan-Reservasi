<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PilihKamarController extends Controller
{
    public function index(Request $request)
    {
        $resources = Resource::where('is_active', true);

        // Filter Kapasitas (Dewasa & Anak)
        if ($request->filled('adults')) {
            $resources->where('max_adults', '>=', (int) $request->adults);
        }
        
        if ($request->filled('children')) {
            $resources->where('max_children', '>=', (int) $request->children);
        }

        // Fallback jika hanya ada 'guests'
        if (!$request->filled('adults') && !$request->filled('children') && $request->filled('guests')) {
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

        return view('user.pilih-kamar', [
            'resources' => $resources->get(),
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'guests' => $request->guests,
            'rooms' => $request->rooms,
        ]);
    }
}

