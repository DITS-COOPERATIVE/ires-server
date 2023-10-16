<?php

namespace App\Http\Controllers\api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $Customer = Customer::all();

        if ($Customer->count() > 0) {

           return $Customer;

        } else {

            return $Customer;

        }

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|string|max: 191',
            'last_name'     => 'required|string|max: 191',
            'gender'        => 'required|string|max: 191',
            'email'         => 'required|email',
            'mobile_no'     => 'required',
            'address'       => 'required',
            'birth_date'    => 'required',
            'privilege'     => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator->messages()
            ], 422);
        } else {
            $Customer = Customer::create([
                'first_name'    =>  $request->first_name,
                'last_name'     =>  $request->last_name,
                'gender'        =>  $request->gender,
                'email'         =>  $request->email,
                'birth_date'    =>  $request->birth_date,
                'mobile_no'     =>  $request->mobile_no,
                'address'       =>  $request->address,
                'privilege'     =>  $request->privilege,
                'points'        =>  0,
            ]);
            if ($Customer) {

                return $Customer;

            } else {

                return $Customer;
            
            }
        }
    }
    public function show(int $id)
    {
        $Customer = Customer::where('id', $id)->get();

        if ($Customer) {

            return $Customer;

        } else {

            return $Customer;
            
        }
    }

    public function edit($id)
    {
        $Customer = Customer::find($id);

        if ($Customer) {

            return $Customer;

        } else {

            return $Customer;

        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|string|max: 191',
            'last_name'     => 'required|string|max: 191',
            'gender'        => 'required|string|max: 191',
            'email'         => 'required|email',
            'mobile_no'     => 'required',
            'points'        => 'required',
            'address'       => 'required',
            'birth_date'    => 'required',
            'privilege'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator->messages()
            ], 422);
        } else {

            $Customer = Customer::find($id);

            if ($Customer) {

                $Customer = Customer::find($id)->update([
                    'first_name'    =>  $request->first_name,
                    'last_name'     =>  $request->last_name,
                    'gender'        =>  $request->gender,
                    'email'         =>  $request->email,
                    'birth_date'    =>  $request->birth_date,
                    'mobile_no'     =>  $request->mobile_no,
                    'address'       =>  $request->address,
                    'privilege'     =>  $request->privilege,
                    'points'        =>  $request->points
                ]);

                return $Customer;
                
            } else {

                return $Customer;

            }
        }
    }

    public function destroy($id)
    {
        $Customer = Customer::find($id);
        
        if ($Customer) {

            $Customer->delete();

            return $Customer;

        } else {

            return $Customer;

        }
    }
}
