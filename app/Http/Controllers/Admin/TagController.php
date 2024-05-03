<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tag::query();

        // Apply search filter
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        // Apply date filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Apply sorting
        $sortColumn = $request->input('sort_column', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $query->orderBy($sortColumn, $sortDirection);

        // Paginate the results
        $pageSize = $request->input('page_size', 10);
        $data = $query->paginate($pageSize);

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();

        // Create a new tag instance with the validated data
        $tag = Tag::create($validatedData);

        // Return a JSON response indicating success
        return response()->json(['tag' => $tag, 'message' => 'Tag created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        if (!$tag) {
            return response()->json(['message' => 'Tag not found'], 404);
        }

        return response()->json(['tag' => $tag], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();

        // Update the tag instance with the validated data
        $tag->update($validatedData);

        // Return a JSON response indicating success
        return response()->json(['tag' => $tag, 'message' => 'Tag updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Delete the tag
        $tag->delete();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Tag deleted successfully'], 200);
    }
}
