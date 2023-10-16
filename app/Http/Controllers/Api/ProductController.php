<?php

namespace App\Http\Controllers\api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function index()
    {
        $Product = Product::all();
        if ($Product->count() > 0) {

            return $Product;
        } else {

            return $Product;
        }
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
            $Product = Product::create([
                'name'          =>  $request->name,
                'code'          =>  $request->code,
                'model'         =>  $request->model,
                'price'         =>  $request->price,
                'quantity'      =>  $request->quantity,
                'points'        =>  $request->points
            ]);

            if ($Product) {

                return $Product;
                
            } else {

                return $Product;

            }
        }
    }

    public function show(int $id)
    {
        $Product = Product::where('id', $id)->get();

        if ($Product) {

            return $Product;

        } else {

            return $Product;

        }
    }

    public function edit(int $id)
    {
        $Product = Product::where('id', $id)->get();
        if ($Product) {

            return $Product;

        } else {

            return $Product;
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

            $Product = Product::find($id);

            if ($Product) {

                $Product = Product::find($id)->update([
                    'name'          =>  $request->name,
                    'code'          =>  $request->code,
                    'model'         =>  $request->model,
                    'price'         =>  $request->price,
                    'quantity'      =>  $request->quantity,
                    'points'        =>  $request->points
                ]);

                return $Product;

            } else {

                return $Product;
                
            }
        }
    }

    public function destroy($id)
    {
        $Product = Product::find($id);

        if ($Product) {

            $Product->delete();

            return $Product;
            
        } else {

            return $Product;
        }
    }
}
