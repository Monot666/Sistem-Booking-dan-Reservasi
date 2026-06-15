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
        
        // Step 1: Process Deletions
        for ($i = 1; $i <= $maxPhotos; $i++) {
            $deleteKey = 'delete_' . $i;
            if ($request->has($deleteKey) && $request->input($deleteKey) == '1') {
                \App\Models\Banner::where('layout_name', $layoutName)->where('position', "Foto $i")->delete();
            }
        }

        // Step 2: Gather remaining existing and new files/links in order
        $validItems = [];
        for ($i = 1; $i <= $maxPhotos; $i++) {
            // Skip if deleted in this request
            if ($request->has("delete_$i") && $request->input("delete_$i") == '1') continue;

            $fileKey = 'file_' . $i;
            $linkKey = 'link_' . $i;
            $position = "Foto $i";

            $existingBanner = \App\Models\Banner::where('layout_name', $layoutName)->where('position', $position)->first();
            $file = $request->hasFile($fileKey) ? $request->file($fileKey) : null;
            $link = $request->has($linkKey) ? $request->input($linkKey) : null;

            if ($existingBanner || $file || $link !== null) {
                // If it's totally empty and no existing banner, skip
                if (!$existingBanner && !$file && empty($link)) continue;
                
                $validItems[] = [
                    'existing' => $existingBanner,
                    'file' => $file,
                    'link' => $link
                ];
            }
        }

        // Step 3: Save them sequentially
        $positionCounter = 1;
        foreach ($validItems as $item) {
            $banner = $item['existing'] ?? new \App\Models\Banner();
            $banner->layout_name = $layoutName;
            $banner->position = "Foto $positionCounter";
            $banner->is_active = true;

            if ($item['file']) {
                $file = $item['file'];
                $filename = time() . '_' . rand(1000, 9999) . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/banners'), $filename);
                $banner->image_path = 'uploads/banners/' . $filename;
            }

            if ($item['link'] !== null) {
                $link = $item['link'];
                // Tambahkan https:// jika user hanya mengetik google.com (tidak ada http:// atau https://)
                if (!preg_match("~^(?:f|ht)tps?://~i", $link) && !empty(trim($link))) {
                    $link = "https://" . $link;
                }
                $banner->external_link = $link;
            }

            $banner->save();
            $positionCounter++;
        }

        // Step 4: Cleanup any leftover old positions that exceed the new compacted count
        for ($i = $positionCounter; $i <= $maxPhotos; $i++) {
            \App\Models\Banner::where('layout_name', $layoutName)->where('position', "Foto $i")->delete();
        }

        return response()->json(['message' => 'Pembaruan layout berhasil disimpan!']);
    }
}
