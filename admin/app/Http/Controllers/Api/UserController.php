<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\User;
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
}
