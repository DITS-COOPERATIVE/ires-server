<?php

namespace App\Http\Controllers\api;

use App\Models\Products;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function show()
    {
        $customers = Customers::all();

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

        $products = Products::all();

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

        return view('dashboard')
            ->with('customers', $total_customers)
            ->with('products', $total_products);



    }
}
