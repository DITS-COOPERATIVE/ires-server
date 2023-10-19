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

        return response()->json([
            'result' => $Customer
        ]);

    }
    public function store(CustomerValidationRequest $request)
    {
        $validated = $request->validated();

        $Customer = Customer::create([
            $validated,
            'points'        =>  0,
        ]);

        return response()->json([
            'result' => $Customer
        ]);
    }
    public function show(int $id)
    {
        $Customer = Customer::where('id', $id)->get();

        return response()->json([
            'result' => $Customer
        ]);
    }

    public function edit($id)
    {
        $Customer = Customer::find($id);

        return response()->json([
            'result' => $Customer
        ]);
    }

    public function update(CustomerValidationRequest $request, int $id)
    {
        $validated = $request->validated();

        $Customer = Customer::find($id)->update([
            $validated,
            'points'        =>  $request->points
        ]);

        return response()->json([
            'result' => $Customer
        ]);
    }

    public function destroy($id)
    {
        $Customer = Customer::find($id);
        
        return response()->json([
            'result' => $Customer
        ]);
    }
}
