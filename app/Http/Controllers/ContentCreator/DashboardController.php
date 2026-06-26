<?php

namespace App\Http\Controllers\ContentCreator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $banners = \App\Models\Banner::all();
        return view('content_creator.dashboard', compact('banners'));
    }

    public function upload(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'layout_name' => 'required|string',
        ]);

        $layoutName = $request->layout_name;
        
        $maxPhotos = 1;
        if ($layoutName === 'Dashboard Explore') $maxPhotos = 4;
        elseif ($layoutName === 'Pembayaran') $maxPhotos = 2;
        
        for ($i = 1; $i <= $maxPhotos; $i++) {
            $position = "Foto $i";

            // Check for deletion
            if ($request->has("delete_$i") && $request->input("delete_$i") == '1') {
                \App\Models\Banner::where('layout_name', $layoutName)->where('position', $position)->delete();
                continue;
            }

            $file = $request->hasFile("file_$i") ? $request->file("file_$i") : null;
            // Get link if present, or null if totally omitted from request
            $link = $request->has("link_$i") ? $request->input("link_$i") : null;

            $banner = \App\Models\Banner::where('layout_name', $layoutName)->where('position', $position)->first();

            // If there's new data to update (either file or link is provided)
            if ($file || $link !== null) {
                if (!$banner) {
                    // Hanya buat baru jika memang ada file (kalau hanya link tanpa gambar, abaikan)
                    if (!$file) continue;
                    
                    $banner = new \App\Models\Banner();
                    $banner->layout_name = $layoutName;
                    $banner->position = $position;
                    $banner->is_active = true;
                }

                // Update File
                if ($file) {
                    $filename = time() . '_' . rand(1000, 9999) . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/banners'), $filename);
                    $banner->image_path = 'uploads/banners/' . $filename;
                }

                // Update Link
                if ($link !== null) {
                    if (!preg_match("~^(?:f|ht)tps?://~i", $link) && !empty(trim($link))) {
                        $link = "https://" . $link;
                    }
                    $banner->external_link = $link;
                }

                $banner->save();
            }
        }

        return response()->json(['message' => 'Pembaruan layout berhasil disimpan!']);
    }
}
