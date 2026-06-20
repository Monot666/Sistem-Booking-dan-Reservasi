<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Admin controller for managing rooms (CRUD).
 */
class RoomController extends Controller
{
    /**
     * Display all rooms for the admin panel.
     */
    public function index()
    {
        $rooms = Room::all();

        return view('admin.kamar', compact('rooms'));
    }

    /**
     * Store a newly created room.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string',
            'type'           => 'required|string',
            'description'    => 'nullable|string',
            'capacity'       => 'required|integer',
            'price_per_hour' => 'required|numeric',
            'facilities'     => 'nullable|array',
        ]);

        if(isset($data['facilities'])) {
            $data['facilities'] = implode(', ', $data['facilities']);
        } else {
            $data['facilities'] = '';
        }

        $room = Room::create($data);

        return back()->with('success', 'Room created successfully');
    }

    /**
     * Update an existing room.
     */
    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name'           => 'sometimes|required|string',
            'type'           => 'sometimes|required|string',
            'description'    => 'nullable|string',
            'capacity'       => 'sometimes|required|integer',
            'price_per_hour' => 'sometimes|required|numeric',
            'facilities'     => 'nullable|array',
        ]);

        if(isset($data['facilities'])) {
            $data['facilities'] = implode(', ', $data['facilities']);
        } else {
            $data['facilities'] = '';
        }

        $room->update($data);

        return back()->with('success', 'Room updated successfully');
    }

    /**
     * Delete a room.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'message' => 'Room deleted successfully',
        ], 200);
    }
}