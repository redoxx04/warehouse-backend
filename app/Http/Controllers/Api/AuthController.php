<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $registrationData = $request->all();
        $validate = Validator::make($registrationData, [
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'contact_user' => 'nullable',
            'address_user' => 'nullable',
            'id_role' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        } 
        
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'contact_user' => $request->contact_user,
            'address_user' => $request->address_user,
            'id_role' => $request->id_role,
        ]);

        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'User registered successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); 
        
        if(!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'], 401);

        $token = $request->user()->createToken('Authentication Token');

        return response([
            'message' => 'Authenticated',
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_in' => $token->expiresIn(),
        ]);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response(['message' => 'Succesfully logged out']);
    }
}
