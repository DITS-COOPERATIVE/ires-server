<?php

namespace App\Http\Controllers\api;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderValidationRequest;
class OrderController extends Controller
{

    public function index()
    {
        $Order = Order::with(['product','customer'])->get();
        return $Order;
    }

    public function store(OrderValidationRequest $request)
    {
        $validated = $request->validated();
        $product = Product::find($request->product_id);

        $Order = Order::create([
            ... $validated,
            'status'=> "PENDING",
        ]);

        $product = Product::find($Order->product_id);

        if ($product->quantity < $Order->quantity) {

            $message = 'Stock is not sufficient. Try again';
            return $message;

        } else {

            Sale::create([
                'order_id'      =>  $Order->id,
                'total_price'   =>  $product->price * $Order->quantity,
                'total_points'  =>  $product->points * $Order->quantity,
            ]);

            $new_quantity = $product->quantity - $Order->quantity;
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
