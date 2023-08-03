<?php

namespace App\Http\Controllers\api;

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index (Request $request)
    {
        $customers = Customers:: all();
        if ($customers -> count() > 0) {
        
        $data = [
                'status' => 200,
                'Customers' => $customers  
                ];
            return response()->json($data, 200);

        }else{
            
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
            'first_name'    => 'required|string|max: 191',
            'last_name'     => 'required|string|max: 191',
            'gender'        => 'required|string|max: 191',
            'email'         => 'required|email',
            'mobile_no'     => 'required',
            'points'        => 'required',
            'address'       => 'required',
            'birth_date'    => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator ->messages()
            ],422);
        }else{
            $customers = Customers::create([
                'first_name'    =>  $request->first_name,
                'last_name'     =>  $request->last_name,
                'gender'        =>  $request->gender,
                'email'         =>  $request->email,
                'birth_date'    =>  $request->birth_date,
                'mobile_no'     =>  $request->mobile_no,
                'address'       =>  $request->address,
                'points'        =>  $request->points
            ]); 
            if ($customers) {

                return response()->json([
                    'status'    =>  200,
                    'message'   => "Customer Information added successfully"
                ], 200);

            }else{

                return response()->json([
                    'status'    =>  500,
                    'message'   => "Something went wrong!"
                ], 500);
            }
        }
    }
    public function show($id)
    {
        $customers = Customers::find($id);
        if ($customers) {

            return response()->json([
                'status'    =>  200,
                'customers'   => $customers
            ], 200);

        }else{

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }

    public function edit($id)
    {
        $customers = Customers::find($id);
        if ($customers) {

            return response()->json([
                'status'    =>  200,
                'customers'   => $customers
            ], 200);

        }else{

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'first_name'    => 'required|string|max: 191',
            'last_name'     => 'required|string|max: 191',
            'gender'        => 'required|string|max: 191',
            'email'         => 'required|email',
            'mobile_no'     => 'required',
            'points'        => 'required',
            'address'       => 'required',
            'birth_date'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator ->messages()
            ],422);

        }else{

            $customers = Customers::find($id);
            
            if ($customers) {

                $customers = Customers::find($id) -> update([
                    'first_name'    =>  $request->first_name,
                    'last_name'     =>  $request->last_name,
                    'gender'        =>  $request->gender,
                    'email'         =>  $request->email,
                    'birth_date'    =>  $request->birth_date,
                    'mobile_no'     =>  $request->mobile_no,
                    'address'       =>  $request->address,
                    'points'       =>  $request->points
                ]); 

                return response()->json([
                    'status'    =>  200,
                    'message'   => "Customer Information updated successfully"
                ], 200);

            }else{

                return response()->json([
                    'status'    =>  404,
                    'message'   => "Data not Found!"
                ], 404);
            }
        }
    }

    public function destroy($id)
    {
        $customers = Customers::find($id);
        if ($customers) {
            $customers -> delete();
            return response()->json([
                'status'    =>  200,
                'message'   => "Customer Information deleted successfully"
            ], 200);

        }else{

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }
}