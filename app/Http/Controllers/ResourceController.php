<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller {
    public function index() { 
        return Resource::all(); 
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'capacity' => 'required|integer',
            'price_per_hour' => 'required|numeric',
        ]);
        return Resource::create($data);
    }

    public function show(Resource $resource) { 
        return $resource; 
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
        return $resource;
    }

    public function destroy(Resource $resource) {
        $resource->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
