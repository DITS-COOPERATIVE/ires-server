<?php

namespace App\Http\Controllers\Api;

use App\Models\UsersInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersInfoController extends Controller
{
    public function index ()
    {
        $usersinfo = UsersInfo:: all();
        if ($usersinfo -> count() > 0) {
        
        $data = [
                'status' => 200,
                'usersinfo' => $usersinfo  
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
            'email'         => 'required|email|max: 191',
            'mobile_no'     => 'required|digits: 11',
            'points'     => 'required|float: 11',
            'address'       => 'required|string|max: 255',
            'birth_date'    => 'required|string|max: 255'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator ->messages()
            ],422);
        }else{
            $usersinfo = UsersInfo::create([
                'first_name'    =>  $request->first_name,
                'last_name'     =>  $request->last_name,
                'gender'        =>  $request->gender,
                'email'         =>  $request->email,
                'birth_date'    =>  $request->birth_date,
                'mobile_no'     =>  $request->mobile_no,
                'address'       =>  $request->address,
                'points'       =>  $request->points
            ]); 
            if ($usersinfo) {

                return response()->json([
                    'status'    =>  200,
                    'message'   => "User Information added successfully"
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
        $userinfo = UsersInfo::find($id);
        if ($userinfo) {

            return response()->json([
                'status'    =>  200,
                'userinfo'   => $userinfo
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
        if ($userinfo) {

            return response()->json([
                'status'    =>  200,
                'userinfo'   => $userinfo
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
            'email'         => 'required|email|max: 191',
            'mobile_no'     => 'required|digits: 11',
            'points'     => 'required|float: 11',
            'address'       => 'required|string|max: 255',
            'birth_date'    => 'required|string|max: 255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'    => 422,
                'errors'    => $validator ->messages()
            ],422);

        }else{

            $usersinfo = UsersInfo::find($id);
            
            if ($usersinfo) {

                $usersinfo = UsersInfo::find($id) -> update([
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
                    'message'   => "User Information updated successfully"
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
        $userinfo = UsersInfo::find($id);
        if ($userinfo) {
            $userinfo -> delete();
            return response()->json([
                'status'    =>  200,
                'message'   => "User deleted successfully!"
            ], 200);

        }else{

            return response()->json([
                'status'    =>  404,
                'message'   => "No Data Found!"
            ], 404);
        }
    }

}
