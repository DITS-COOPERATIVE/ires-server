<?php

namespace App\Http\Controllers\api;

use App\Models\Products;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orders;
use App\Models\Product;

class DashboardController extends Controller
{
    public function show()
    {
        $customers = Customer::all();

        if ($customers->count() > 0) {

            $response = [
                'status'    =>  200,
                'result'   => $customers->count()
            ];

        }else{

            $response = [
                'status'    =>  404,
                'result'   => "No Data Found!"
            ];
        }

        $total_customers = $response['result'];

        $products = Product::all();

        if ($products->count() > 0) {

            $response = [
                'status'    =>  200,
                'result'   => $products->count()
            ];

        }else{

            $response = [
                'status'    =>  404,
                'result'   => "No Data Found!"
            ];
        }

        $total_products = $response['result'];

        $orders = Order::all();

        if ($orders->count() > 0) {

            $response = [
                'status'    =>  200,
                'result'   => $orders->count()
            ];

        }else{

            $response = [
                'status'    =>  404,
                'result'   => "No Data Found!"
            ];
        }

        $total_orders = $response['result'];

        return view('dashboard')
            ->with('customers', $total_customers)
            ->with('products', $total_products)
            ->with('orders', $total_orders)
            ;



    }
}
