<?php

namespace App\Http\Controllers\api;

use App\Models\Sales;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sales::with('orders','orders.customer', 'orders.product')->get();
        if ($sales->count() > 0) {
            
            if ($sales->count() > 0) {
    
            return response()->json([
                'status'    =>  200,
                'result'    => $sales->flatten()
            ], 200);

        } else {

            return response()->json([
                'status'    =>  404,
                'result'   => "No record found."
            ], 404);
        }
    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
