<?php

namespace App\Http\Controllers\api;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderValidationRequest;
use App\Models\Orders_Products;
use App\Models\Service;

class OrderController extends Controller
{

    public function index()
    {
        $Order = Order::with(['product','customer'])->get();
        return $Order;
    }

    public function store(OrderValidationRequest $request)
    {

        $product = Product::find($request->product_id);

        if ($product->quantity < $request->quantity) {

            $message = 'Stock is not sufficient. Try again';
            return $message;

        } else {

            $validated = $request->validated();
            $product = Product::find($request->product_id);
    
            $Order = Order::create([
                ... $validated,
                'status'        => "PENDING",
                'price'         => $product->price * $request->quantity,
                'points'        => $product->points * $request->quantity,
            ]);

            $new_quantity = $product->quantity - $request->quantity;
            $product->quantity = $new_quantity;
            $product->save();

            return $Order;
        }

    }

    public function show(Order $order)
    {
        return $order;
    }

    public function destroy(Order $order)
    {
        $Order = Order::find($order);
        $product = Product::find($Order->product_id);

        $return_order_quantity = $Order->quantity + $product->quantity;
        $product->quantity = $return_order_quantity;
        $product->save();

        $Order->delete();
    }
}
