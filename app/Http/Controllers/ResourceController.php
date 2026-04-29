<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller {
    public function index() { 
        $resources = Resource::where('is_active', true)->get();
        return view('resources.index', compact('resources'));
    }

    public function show(Resource $resource) { 
        return view('resources.show', compact('resource'));
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

    public function show(Resource $resource) { 
        return response()->json([
            'message' => 'Success',
            'data' => $resource
        ], 200);
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
