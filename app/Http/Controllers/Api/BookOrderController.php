<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookOrderRequest;
use App\Http\Requests\UpdateBookOrderRequest;
use App\Models\BookOrder;
use App\Models\Cart;

class BookOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookOrderRequest $request)
    {
        $userId = auth()->id();
        $carts = Cart::where('user_id', $userId)->all();

        if ($carts) {

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BookOrder $bookOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookOrderRequest $request, BookOrder $bookOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookOrder $bookOrder)
    {
        //
    }
}
