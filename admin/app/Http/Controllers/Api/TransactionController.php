<?php

namespace App\Http\Controllers\api;

use App\Models\Sales;
use App\Models\Customers;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transactions::all();
        if ($transactions -> count() > 0) 
        {
        $data = [
                'status' => 200,
                'Transactions' => $transactions,
            ];
        return response()->json($data, 200);
    
        }
        else
        {
                
        $data = [
                'status' => 404,
                'message' => 'No Records Found'  
            ];
        return response()->json($data, 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'sale_id'              => 'required',
            'amount_rendered'       => 'required',
            'change'                => 'required',
        ]);
        if ($validator->fails()) 
        
        {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator ->messages()
            ],422);

        }
        else
        {

            $transaction = Transactions::create([
                'sale_id'           =>  $request->sale_id,
                'amount_rendered'   =>  $request->amount_rendered,
                'change'            =>  $request->change,
            ]);

            if ($transaction) {
                
                $transaction = Transactions::with([
                    'sale.orders.customer' => function ($query){
                        $query->select('id','first_name');
                    },
                    'sale.orders.product' => function ($query){
                        $query->select('id','name');
                    }
                ])->get();

                return response()->json([
                    'status'    =>  200,
                    'message'   =>  'Transaction Added Successfully.',
                    'result'  =>  $transaction,
                ], 200);

            }else{

                return response()->json([
                    'status'    =>  500,
                    'message'   => "Something went wrong!"
                ], 500);
            }
        }    
    }

    public function show(string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
