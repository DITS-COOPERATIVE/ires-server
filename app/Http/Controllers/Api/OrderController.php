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
        $products  = $request->products;
        $order = Customer::find($request->customer_id);
        $order->save();
        $order->products()->attach($products);

        return Order::with(['products'])->where('customer_id','=', $request->customer_id)->get();
    }

    public function show(string $id)
    {
        $order = Order::with(['products'])->where('customer_id','=', $id)->get();
        return $order;
    }

    public function update(OrderValidationRequest $request)
    {
        $products  = $request->products;
        $order = Customer::find($request->customer_id);
        $order->products()->sync($products);

        return Order::with(['products'])->where('customer_id','=', $request->customer_id)->get();
    }

    public function destroy(Order $order)
    {
        $order->delete();
    }
}
