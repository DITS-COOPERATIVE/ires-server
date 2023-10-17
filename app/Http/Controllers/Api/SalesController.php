<?php

namespace App\Http\Controllers\api;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaleValidationRequest;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Sale = Sale::with('orders','orders.customer', 'orders.product');

        return response()->json([
            'result' => $Sale
        ]);
    }
    public function store(SaleValidationRequest $request)
    {
        $validated = $request->validated();

        $Sale = Sale::create($validated);

        return response()->json([
            'result' => $Sale
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Sale = Sale::where('id', $id);

        return response()->json([
            'result'   => $Sale,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(SaleValidationRequest $request, string $id)
    {
        $validated = $request->validated();

        $Sale = Sale::find($id)->update([
            $validated
        ]);

        return response()->json([
            'result'   => $Sale,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Sale = Sale::find($id)->delete();

        return response()->json([
            'result'   => $Sale,
        ]);
    }
}
