<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        // Mengambil semua data kamar dari database
        $rooms = DB::table('resources')->get();
        
        return view('admin.kamar', compact('rooms'));
    }
}