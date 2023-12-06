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
        return $Product;
    }

    public function store(ProductValidationRequest $request)
    {
        $validated = $request->validated();

        $Product = Product::create([
            ... $validated,
            'barcode'    =>  random_int(10000000, 99999999),
        ]);
        return $Product;
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(ProductValidationRequest $request, Product $product)
    {
        $validated = $request->validated();
        $product->update([
            ... $validated,
        ]);
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
    }
}
