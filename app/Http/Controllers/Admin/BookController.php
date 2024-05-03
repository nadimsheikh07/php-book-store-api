<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

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
    public function store(StoreBookRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();

        // Create a new book instance with the validated data
        $book = Book::create($validatedData);

        // Return a JSON response indicating success
        return response()->json(['book' => $book, 'message' => 'Book created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json(['book' => $book], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();

        // Update the book instance with the validated data
        $book->update($validatedData);

        // Return a JSON response indicating success
        return response()->json(['book' => $book, 'message' => 'Book updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Delete the book
        $book->delete();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
