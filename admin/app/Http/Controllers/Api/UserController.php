<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\User;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function create(Request $request)
    {
        try {
            //Validate
            $validateUser = Validator::make($request->all(),
            [

                'username'  =>  'required',
                'password'  =>  'required',
                'email'     =>  'required|email',
            ]);
            if ($validateUser->fails()) {
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  'validation error',
                    'errors'    =>  $validateUser->errors()
                ],401);
            }

            $user = User::create([
                'username'  =>  $request->username,
                'password'  =>  Hash::make($request->password),
                'email'     =>  $request->email,
                'user_type' =>  "ADMIN",
                'is_active' =>  true,
            ]);

            return response()->json([
                'status'    =>  true,
                'message'   =>  'User Created Successfully',
                'token'    =>  $user->createToken("API_TOKEN")->plainTextToken
            ],200);

        } catch (Throwable $th) {
            return response()->json([
                'status'    =>  false,
                'message'   =>  $th->getMessage(),
            ],500);//throw $th;
        }
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'username'  =>  'required',
                'password'  =>  'required',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  'validation error',
                    'errors'    =>  $validateUser->errors()
                ],401);
            }

            if (!Auth::attempt($request->only(['username','password']))) {
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  'Username & Password is invalid!',
                ],401);
            }

            $user = User::where('username', $request->username)->first();
            $token = $user->createToken("API_TOKEN")->plainTextToken;
            $cookie = cookie('jwt',$token, 60 * 24);

            return response()->json([
                'status'    =>  true,
                'message'   =>  'User Login Successfully',
                'token'     =>  $token
            ],200)->withCookie($cookie);

        } catch (Throwable $th) {
            return response()->json([
                'status'    =>  false,
                'message'   =>  $th->getMessage(),
            ],500);//throw $th;
        }
    }

    public function logout(Request $request)
    {   

        $cookie = Cookie::forget('jwt');

        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'User Logout Successfully',
        ],200);
        
        
    }

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
                'points'       =>  $request->points
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
