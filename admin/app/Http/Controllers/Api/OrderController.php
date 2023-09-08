<?php

namespace App\Http\Controllers\api;

use App\Models\Sales;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customers;
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
        $customer = Customers::find($request->customer_id);
        $product = Products::find($request->product_id);

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

            if (!$customer||!$product) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data not found. Try again'
                ], 404);
            }

            $orders = Orders::create([
                'customer_id'       =>  $request->customer_id,
                'product_id'        =>  $request->product_id,
                'quantity'          =>  $request->quantity,
                'status'            =>  "PENDING",
            ]);

            if ($orders) {

                $product = Products::find($orders->product_id);

                if ($product->quantity < $orders->quantity) {

                    return response()->json([
                        'status' => 404,
                        'message' => 'Stock is not sufficient. Try again'
                    ], 404);
    
                } else {

                    Sales::create([
                        'order_id'      =>  $orders->id,
                        'total_price'   =>  $product->price * $orders->quantity,
                        'total_points'  =>  $product->points * $orders->quantity,
                    ]);
    
                    $new_quantity = $product->quantity - $orders->quantity;
                    $product->quantity = $new_quantity;
                    $product->save();
    
                    return response()->json([
                        'status'    =>  200,
                        'message'   => "Order added Successfully"
                    ], 200);
                }

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
        $product = Products::find($orders->product_id);

        if ($orders) {

            $return_order_quantity = $orders->quantity + $product->quantity;
            $product->quantity = $return_order_quantity;
            $product->save();

            $orders->delete();
            return response()->json([   
                'status'    =>  200,
                'message'   => ["Order deleted successfully", $product->quantity]
            ], 200);
        } else {

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }
}
