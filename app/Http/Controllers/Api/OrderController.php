<?php

namespace App\Http\Controllers\api;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function index()
    {
        $Order = Order::with('product', 'customer')->get();

        if ($Order->count() > 0) {

            return response()->json([
                'status' => 200,
                'result' => $Order,
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
        $customer = Customer::find($request->customer_id);
        $product = Product::find($request->product_id);

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

            $Order = Order::create([
                'customer_id'       =>  $request->customer_id,
                'product_id'        =>  $request->product_id,
                'quantity'          =>  $request->quantity,
                'status'            =>  "PENDING",
            ]);

            if ($Order) {

                $product = Product::find($Order->product_id);

                if ($product->quantity < $Order->quantity) {

                    return response()->json([
                        'status' => 404,
                        'message' => 'Stock is not sufficient. Try again'
                    ], 404);
    
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
        $Order = Order::where('id', $id)->get();

        if ($Order) {

            return response()->json([
                'status' => 200,
                'result' => $Order->flatten()->first(),
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
        $Order = Order::find($id);
        $product = Product::find($Order->product_id);

        if ($Order) {

            $return_order_quantity = $Order->quantity + $product->quantity;
            $product->quantity = $return_order_quantity;
            $product->save();

            $Order->delete();
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
