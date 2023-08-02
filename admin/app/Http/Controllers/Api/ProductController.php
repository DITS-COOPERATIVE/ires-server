<?php

namespace App\Http\Controllers\api;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index (Request $request)
    {
        $products = Products:: all();
        if ($products -> count() > 0) {
        
        $data = [
                'status' => 200,
                'usersinfo' => $products  
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
            'name'          => 'required|string|max: 191',
            'code'          => 'required|string|max: 191',
            'model'         => 'required|string|max: 191',
            'price'         => 'required',
            'quantity'      => 'required',
            'points'        => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator ->messages()
            ],422);

        }else{
            $products = Products::create([
                'name'          =>  $request->name,
                'code'          =>  $request->code,
                'model'         =>  $request->model,
                'price'         =>  $request->price,
                'quantity'      =>  $request->quantity,
                'points'        =>  $request->points
            ]); 
            if ($products) {

                return response()->json([
                    'status'    =>  200,
                    'message'   => "Product added successfully"
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
        $products = Products::find($id);
        if ($products) {

            return response()->json([
                'status'    =>  200,
                'userinfo'   => $products
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
        $products = Products::find($id);
        if ($products) {

            return response()->json([
                'status'    =>  200,
                'userinfo'   => $products
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
            'name'          => 'required|string|max: 191',
            'code'          => 'required|string|max: 191',
            'model'         => 'required|string|max: 191',
            'price'         => 'required',
            'quantity'      => 'required',
            'points'        => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator ->messages()
            ],422);

        }else{

            $products = Products::find($id);
            
            if ($products) {

                $products = Products::find($id) -> update([
                    'name'          =>  $request->name,
                    'code'          =>  $request->code,
                    'model'         =>  $request->model,
                    'price'         =>  $request->price,
                    'quantity'      =>  $request->quantity,
                    'points'        =>  $request->points
                ]); 

                return response()->json([
                    'status'    =>  200,
                    'message'   => "Product updated successfully"
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
        $products = Products::find($id);
        if ($products) {
            $products -> delete();
            return response()->json([
                'status'    =>  200,
                'message'   => "Product deleted successfully!"
            ], 200);

        }else{

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }
}
