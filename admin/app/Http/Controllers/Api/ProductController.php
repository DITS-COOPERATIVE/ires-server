<?php

namespace App\Http\Controllers\api;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function create()
    {
        return view('products-create');
    }

    public function index()
    {
        $products = Products::all();
        if ($products->count() > 0) {

            $data = [
                'status' => 200,
                'result' => $products
            ];
        } else {

            $data = [
                'status' => 404,
                'result' => 'No Records Found'
            ];
        }
        return view('products')->with(['result' => $data['result']]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max: 191',
            'code'          => 'required|string|max: 191',
            'model'         => 'required|string|max: 191',
            'price'         => 'required|numeric',
            'quantity'      => 'required|numeric',
            'points'        => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator->messages()
            ], 422);
        } else {
            $products = Products::create([
                'name'          =>  $request->name,
                'code'          =>  $request->code,
                'model'         =>  $request->model,
                'price'         =>  $request->price,
                'quantity'      =>  $request->quantity,
                'points'        =>  $request->points
            ]);
            if ($products) {

                $data = [
                    'status'    =>  200,
                    'message'   => "Product added successfully"
                ];
            } else {

                $data = [
                    'status'    =>  500,
                    'message'   => "Something went wrong!"
                ];
            }
            return redirect(route('products.index'))->with(['data' => $data]);
        }
    }

    public function show(int $id)
    {
        $products = Products::where('id', $id)->get();

        if ($products) {
            $data = [
                'status' => 200,
                'result' => $products->flatten()->first(),
            ];
        } else {
            $data = [
                'status' => 404,
                'result' => "No Result Found.",
            ];
        }
        return view('products-view', [
            'products' => $data['result'],
        ]);
    }

    public function edit($id)
    {
        $products = Products::find($id);
        if ($products) {

            return response()->json([
                'status'    =>  200,
                'userinfo'   => $products
            ], 200);
        } else {

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max: 191',
            'code'          => 'required|string|max: 191',
            'model'         => 'required|string|max: 191',
            'price'         => 'required|numeric',
            'quantity'      => 'required|numeric',
            'points'        => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator->messages()
            ], 422);
        } else {

            $products = Products::find($id);

            if ($products) {

                $products = Products::find($id)->update([
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
            } else {

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
            $products->delete();
            return response()->json([
                'status'    =>  200,
                'message'   => "Product deleted successfully!"
            ], 200);
        } else {

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }
}
