<?php

namespace App\Http\Controllers\api;

use App\Models\Sale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SaleValidationRequest;

class SaleController extends Controller
{
    public function index()
    {
        $Sale = Sale::with(['orders','orders.customer', 'orders.product'])->get();
        return $Sale;
    }
    public function store(SaleValidationRequest $request)
    {
        $validated = $request->validated();
        $Sale = Sale::create(...$validated);
        return $Sale;
    }

    public function show(Sale $sale)
    {
        return $sale;
    }
    public function update(SaleValidationRequest $request, Sale $sale)
    {
        $validated = $request->validated();
        $sale->update([
            $validated
        ]);
        return $sale;
    }
    public function destroy(Sale $sale)
    {
        $sale->delete();
    }
}
