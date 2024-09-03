<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Http\Requests\RegistrationRequest;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request){

        $user = User::where('email',$request->email)->first();

        
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->role = $request->get('role');
            $user->phone = $request->get('phone');
            $user->password = bcrypt($request->password);
            $user->save();


            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status'=>true,
                'message'=>'User created successfully',
                'userToken'=>$token,
                'data'=>$user
            ]);
         
    }

    public function login(Request $request){
        
        $credentials = $request->only(['email','password','role']);

        if(Auth::attempt($credentials)){

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status'=>true,
                'token'=>$token,
                'message'=>'User logged in successfully',
                'data'=>$user
            ]);



        }else {
            return response()->json([
                'status'=>false,
                'message'=>'wrong email or password'
            ]);
        };


    }


    public function logout(Request $request)
    {
        
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User logged out successfully'
        ]);
    }
}
