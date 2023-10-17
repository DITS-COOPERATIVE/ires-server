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
        $Order = Order::with('product', 'customer')->get();

        return response()->json([
            'result' => $Order,
        ]);
    }

    public function store(OrderValidationRequest $request)
    {
        $validated = $request->validated();
        $product = Product::find($request->product_id);

        $Order = Order::create([
            $validated,
            'status'            =>  "PENDING",
        ]);

        $product = Product::find($Order->product_id);

        if ($product->quantity < $Order->quantity) {

            return response()->json([
                'result' => 'Stock is not sufficient. Try again'
            ]);

        } else {

            Sale::create([
                'order_id'      =>  $Order->id,
                'total_price'   =>  $product->price * $Order->quantity,
                'total_points'  =>  $product->points * $Order->quantity,
            ]);

            $new_quantity = $product->quantity - $Order->quantity;
            $product->quantity = $new_quantity;
            $product->save();

            return response()->json([
                'result'   => "Order added Successfully"
            ]);
        }

    }

    public function show(string $id)
    {
        $Order = Order::where('id', $id);

        return response()->json([
            'result' => $Order,
        ]);
    }

    public function destroy(string $id)
    {
        $Order = Order::find($id);
        $product = Product::find($Order->product_id);

        $return_order_quantity = $Order->quantity + $product->quantity;
            $product->quantity = $return_order_quantity;
            $product->save();

            $Order->delete();
            return response()->json([   
                'message'   => ["Order deleted successfully", $product->quantity]
            ]);
    }
}
