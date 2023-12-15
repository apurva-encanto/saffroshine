<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController;

class AuthController extends BaseController
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error.', [$validator->errors()]);

        }
        $input=['email'=>$request->email,'password'=> $request->password];

       $adminExists=Admin::where('email', $request->email)->first();

        if($adminExists)
        {
            if (Auth::guard('admin')->attempt($input)) {

                $user = Auth::guard('admin')->user();
                $token = $user->createToken('auth_token')->plainTextToken;
                $data=(['users' => $user, 'token' => $token]);

                return $this->sendResponse($data, 'User Login successfully.');

            } else {
                return $this->sendError('Password is Incorrect.', []);

            }
        }else{
            return $this->sendError('User not exists.', []);

        }

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function users()
    {

        echo "ok";
    }

    public function loginCheck()
    {
        return $this->sendError('Unauthorized.', ["Authentication token is missing. Please include a valid API token in the request headers."]);
    }
    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['data' => $validator->errors(), 'status' => 'failed', 'errorCode' => 0], 200);
        }

        $input = ['email' => $request->email, 'password' => $request->password];
        $userExists=User::where('email', $request->email)->first();
        if($userExists){
            if (Auth::attempt($input)) {
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;
                $data=(['users' => $user, 'token' => $token]);
                return $this->sendResponse($data, 'User Login successfully.');
            }else{
                return $this->sendError('Password is Incorrect.', []);

            }
        }else{
            return $this->sendError('User not exists.', []);
        }

    }


}
