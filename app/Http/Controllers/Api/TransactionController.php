<?php

namespace App\Http\Controllers\api;

use App\Models\Sale;
use App\Models\Customers;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function create($id)
    {
        $Sale = Sale::with('Order')->where('id', $id)->get()->flatten()->first();
        $Order = $Sale->Order->flatten()->first();
        $customer_id = $Order->customer_id;

        $count = Order::where('customer_id', $customer_id)->count();
        $amount = $Sale->total_price;

        return view('Transaction-create', [
            'Sale' => $Sale,
            'Order' => $Order,
            'amount' => $amount,
            'count' => $count,
        ]);
    }

    public function index()
    {
        $Transaction = Transaction::with('sale.Order.customer','sale.Order.product')->get();

        if ($Transaction->count() > 0) {

            return $Transaction;

        } else {
            
            return $Transaction;

        }
    }
    public function store(Request $request)
    {
        $Sale = Sale::where('id', '=', $request->sale_id)->first();
        $total_price = $Sale->total_price;
        $change = $request->amount_rendered - $total_price;

        $validator = Validator::make($request->all(), [
            'sale_id'               => 'required',
            'amount_rendered'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator->messages()
            ], 422);
        } else {

            if ($request->amount_rendered < $total_price) {

                $error = "Ammount Rendered is insufficient. Please try again.";

                return response()->json([
                    'message'   => $error,
                ]);

            } else {

                $transaction = Transaction::create([
                    'sale_id'           =>  $request->sale_id,
                    'amount_rendered'   =>  $request->amount_rendered,
                    'change'            =>  $change,
                ]);
            }


            if ($transaction) {

                $points = Transaction::with([
                    'sale' => function ($query) {
                        $query->select('id', 'total_points');
                    }
                ])
                    ->get()
                    ->pluck('sale')
                    ->first()
                    ->value('total_points');

                $customer_id = Transaction::with([
                    'sale.Order' => function ($query) {
                        $query->select('id', 'customer_id');
                    }
                ])
                    ->get()
                    ->pluck('sale.Order')
                    ->first()
                    ->value('customer_id');

                $customer = Customer::where('id', '=', $customer_id)->first();
                $new_points = $customer->points + $points;
                $customer->points = $new_points;
                $customer->save();

                return response()->json([
                    'status'    =>  201,
                    'message'   => "Transaction Added Successfully"
                ], 201);
            } else {

                return response()->json([
                    'status'    =>  500,
                    'message'   => "Something went wrong!"
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);
        if ($transaction) {
            return response()->json([
                'status'    =>  200,
                'userinfo'   => $transaction
            ], 200);
        } else {
            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        $Transaction = Transaction::find($id);
        if ($Transaction) {
            $Transaction->delete();
            return response()->json([
                'status'    =>  200,
                'message'   => "Transaction Delete successfully!"
            ], 200);
        } else {

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }
}
