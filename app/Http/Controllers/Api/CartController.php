<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCartRequest;
use App\Http\Requests\Api\UpdateCartRequest;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->id();

        $query = Cart::query();

        $query->with(['book']);

        $query->where('user_id', $userId);

        $data = $query->get();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $userId = auth()->id();

        // Validate the incoming request data
        $validatedData = $request->validated();

        $validatedData['user_id'] = $userId;

        // Create a new cart instance with the validated data
        $cart = Cart::create($validatedData);

        // Return a JSON response indicating success
        return response()->json(['cart' => $cart, 'message' => 'cart created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        if (!$cart) {
            return response()->json(['message' => 'cart not found'], 404);
        }

        return response()->json(['cart' => $cart], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $userId = auth()->id();
        // Validate the incoming request data
        $validatedData = $request->validated();

        $validatedData['user_id'] = $userId;

        // Update the cart instance with the validated data
        $cart->update($validatedData);

        // Return a JSON response indicating success
        return response()->json(['cart' => $cart, 'message' => 'cart updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        // Delete the cart
        $cart->delete();

        // Return a JSON response indicating success
        return response()->json(['message' => 'cart deleted successfully'], 200);
    }
}
