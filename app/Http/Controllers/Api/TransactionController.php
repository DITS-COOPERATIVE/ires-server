<?php

namespace App\Http\Controllers\api;

use App\Models\Sale;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TransactionValidationRequest;
use App\Models\Customer;

class TransactionController extends Controller
{
    public function index()
    {
        $Transaction = Transaction::with(['sale.order.customer','sale.order.product'])->get();
        return $Transaction;
    }
    public function store(TransactionValidationRequest $request)
    {
        $validated = $request->validated();

        $Sale = Sale::where('id', '=', $request->sale_id)->first();
        $total_price = $Sale->total_price;
        $change = $request->amount_rendered - $total_price;

        if ($request->amount_rendered < $total_price) {

            $error = "Ammount Rendered is insufficient. Please try again.";

            return $error;

        } else {
            $Transaction = Transaction::create([
                ... $validated,
                'change' =>  $change,
            ]);
        }
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
            'sale.order' => function ($query) {
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

        return $Transaction;
    }

    public function show(Transaction $transaction)
    {
        return $transaction;
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
    }
}
