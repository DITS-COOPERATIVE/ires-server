<?php

namespace App\Http\Controllers\api;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CustomerValidationRequest;

class CustomerController extends Controller
{
    public function index()
    {
        $Customer = Customer::all();
        return $Customer;

    }
    public function store(CustomerValidationRequest $request)
    {
        $validated = $request->validated();
        $Customer = Customer::create([
            ... $validated,
            'points'        =>  0,
        ]);
        return $Customer;
    }
    public function show(Customer $customer)
    {
        return $customer;
    }

    public function update(CustomerValidationRequest $request, Customer $customer)
    {
        $validated = $request->validated();
        $customer->update([
            $validated,
            'full_name' => $validated['full_name'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'mobile_no' => $validated['mobile_no'],
            'address' => $validated['address'],
            'privilege' => $validated['privilege'],
            'points' => $request->points
        ]);
        return $customer;
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
    }
}
