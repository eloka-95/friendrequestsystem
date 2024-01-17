<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Traits\V1\ApiResponseTrait;





class AuthController extends Controller
{
    use ApiResponseTrait;

   
    

    public function register(Request $request)
    {
        $validator = Validator::make($request->only('name', 'email', 'password', 'c_password'), [
            'name' => 'required',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->toArray(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User registered successfully', 201);
    }



    public function login(Request $request)
    {

        $validator = Validator::make($request->only('name', 'email', 'password', 'c_password'), [
            'email' => 'required|string|email',
            'password' => 'required',
        ]);


        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->toArray(), 422);
        }


        if (auth()->attempt($request->only('email', 'password'))) {
            $user = auth()->user();
            $token = $user->createToken('app-token')->plainTextToken;

            $success['token'] = $token;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully', 201);
        }

        return response()->json(['message' => 'Invalid login credentials'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
