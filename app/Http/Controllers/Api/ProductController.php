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

        $product = Product::create([
            ...$validated,
            'barcode'    =>  random_int(10000000, 99999999),
        ]);

        if ($request->hasFile('image')) {
            $product->update([
                'image' => 'storage/' .  $request->file('image')->store('product/images', 'public')
            ]);
        }

        if ($request->subProducts) {
            collect($request->subProducts)->each(fn ($child) => $product->subProducts()->attach([$child['id'] => ['qty' => $child['qty']]]));
        }
        return $product->load('subProducts');
    }

    public function show(Product $product)
    {
        $product->load('subProducts');

        return $product;
    }

    public function update(ProductValidationRequest $request, Product $product)
    {
        $validated = $request->validated();
        $product->update([
            ...$validated,
        ]);

        if ($request->subProducts) {
            $product->subProducts()->detach();
            collect($request->subProducts)->each(fn ($child) => $product->subProducts()->attach([$child['id'] => ['qty' => $child['qty']]]));
        }

        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
    }

    public function destroySubProduct(Product $product, $subProduct)
    {
        $product->subProducts()->detach($subProduct);
        return response()->json(['message' => 'Sub-product deleted successfully']);
    }
}
