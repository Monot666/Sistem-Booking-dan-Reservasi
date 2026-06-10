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
        
        for ($i = 1; $i <= 3; $i++) {
            $fileKey = 'file_' . $i;
            $linkKey = 'link_' . $i;
            $position = 'Foto ' . $i;

            $banner = \App\Models\Banner::firstOrCreate(
                ['layout_name' => $layoutName, 'position' => $position]
            );

            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/banners'), $filename);
                $banner->image_path = 'uploads/banners/' . $filename;
            }

            if ($request->has($linkKey)) {
                $banner->external_link = $request->input($linkKey);
            }

            $banner->save();
        }

        return response()->json(['message' => 'Pembaruan layout berhasil disimpan!']);
    }
}
