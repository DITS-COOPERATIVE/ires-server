<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductValidationRequest;

class ProductController extends Controller
{

    public function index()
    {
        $Product = Product::all();

        return response()->json([
            'result' => $Product
        ]);
    }

    public function store(ProductValidationRequest $request)
    {
        $validated = $request->validated();

        $Product = Product::create($validated);

        return response()->json([
            'result' => $Product
        ]);
    }

    public function show(int $id)
    {
        $Product = Product::where('id', $id)->get();

        return response()->json([
            'result' => $Product
        ]);
    }

    public function edit(int $id)
    {
        $Product = Product::where('id', $id)->get();
        
        return response()->json([
            'result' => $Product
        ]);
    }

    public function update(ProductValidationRequest $request, int $id)
    {
        $validated = $request->validated();

        $Product = Product::find($id)->update($validated);

        return response()->json([
            'result' => $Product
        ]);
    }

    public function destroy($id)
    {
        $Product = Product::find($id)->delete();

        return response()->json([
            'result' => $Product
        ]);

    }
}
