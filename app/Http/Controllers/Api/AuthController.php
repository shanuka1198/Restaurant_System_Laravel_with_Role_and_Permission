<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Helper\ResponseHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function Register(RegisterRequest $request)
    {
        try{
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            if(!$user){
                return ResponseHelper::error('error','User Registration Failed',500);
            }

            return ResponseHelper::success('success','User Registered Successfully',$user,201);
        }catch(\Exception $e){
            return ResponseHelper::error('error',$e->getMessage(),500);
        }
    }

    public function Login(Request $request)
    {
        try{
            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return ResponseHelper::error('error','Invalid Credentials',401);
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return ResponseHelper::success('success','User Logged In Successfully',[
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],200);
        }catch(\Exception $e){
            return ResponseHelper::error('error',$e->getMessage(),500);
        }
    }


    public function Logout(Request $request)
    {
        try{
            $request->user()->tokens()->delete();

            return ResponseHelper::success('success','User Logged Out Successfully',null,200);
        }catch(\Exception $e){
            return ResponseHelper::error('error',$e->getMessage(),500);
        }
    }

    public function UserProfile(Request $request)
    {
        try{
            $user = $request->user();

            return ResponseHelper::success('success','User Profile Retrieved Successfully',$user,200);
        }catch(\Exception $e){
            return ResponseHelper::error('error',$e->getMessage(),500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
