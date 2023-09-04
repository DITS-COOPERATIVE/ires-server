<?php

namespace App\Http\Controllers\api;

use App\Models\Sales;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders-create');
    }

    public function index()
    {
        $orders = Orders::with('product', 'customer')->get();

        if ($orders->count() > 0) {

            return response()->json([
                'status' => 200,
                'result' => $orders,
            ], 200);

        } else {
             return response()->json([
                'status' => 404,
                'result' => 'No Records Found',
             ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'            => 'required',
            'customer_id'           => 'required',
            'quantity'              => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator->messages()
            ], 422);
        } else {

            $orders = Orders::create([
                'customer_id'       =>  $request->customer_id,
                'product_id'        =>  $request->product_id,
                'quantity'          =>  $request->quantity,
            ]);

            if ($orders) {

                $product = Products::find($orders->product_id);

                Sales::create([
                    'order_id'      =>  $orders->id,
                    'total_price'   =>  $product->price * $orders->quantity,
                    'total_points'  =>  $product->points * $orders->quantity,
                ]);

                return response()->json([
                    'status'    =>  200,
                    'message'   => "Order added Successfully"
                ], 200);

            } else {

                return response()->json([
                    'status'    =>  500,
                    'message'   => "Something went wrong!"
                ], 500);
            }
        }
    }

    public function show(string $id)
    {
        $orders = Orders::where('id', $id)->get();

        if ($orders) {

            return response()->json([
                'status' => 200,
                'result' => $orders->flatten()->first(),
            ], 200);

        } else {

            return response()->json([
                'status' => 404,
                'result' => "Order Not Found"
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        $orders = Orders::find($id);
        if ($orders) {
            $orders->delete();
            return response()->json([
                'status'    =>  200,
                'message'   => "Order deleted successfully"
            ], 200);
        } else {

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }
}
