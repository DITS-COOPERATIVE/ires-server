<?php

namespace App\Http\Controllers\api;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderValidationRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Request;

class OrderController extends Controller
{

    public function index()
    {
        $Order = Order::with(['products'])->get();
        return $Order;
    }

    public function store(OrderValidationRequest $request)
    {
        $data = $request->validated();

        $order = Order::create($data);

        collect($request->products)->each(function ($product) use ($order) {
            $order->products()->attach([
                $product['id'] => [
                    'qty' => $product['qty'],
                    'price' => $product['price'],
                    'sub_total' => $product['sub_total'],
                    'points' => $product['points'],
                    'discount' => $product['discount']
                ]
            ]);
        });

        return $order;
    }

    public function show(string $id)
    {
        $order = Order::with(['products'])->where('customer_id', '=', $id)->get();
        return $order;
    }

    public function update(OrderValidationRequest $request)
    {
        $products  = $request->products;
        $order = Customer::find($request->customer_id);
        $order->products()->sync($products);

        return Order::with(['products'])->where('customer_id', '=', $request->customer_id)->get();
    }

    public function destroy(Order $order)
    {
        $order->delete();
    }
}
