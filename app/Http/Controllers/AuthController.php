<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request) 
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|max:10|unique:users',
            'password' => 'required|confirmed'
        ]);
  
        $user = User::create($fields);
        $token = $user -> createToken($request->name);
        $data = [
            'user' => $user,
            'token' => $token -> plainTextToken
        ];
        return $this->apiResponse('success', 'User Created Successfully', $data);            
    }

    public function login(Request $request) 
    {
        $fields = $request -> validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('phone', $request -> phone) -> first();

        if(!$user || Hash::check($request -> password, $user -> password)) {
            $token = $user -> createToken($user -> name);
            return $this -> apiResponse('success', 'Login Successfully', $token -> plainTextToken);
        }

        return $this -> apiResponse('success', 'Login Failed', null);
        
    }

    public function logout(Request $request) 
    {
        $request -> user() -> tokens() -> delete();
        return $this -> apiResponse('success', 'Loged out Successfully', null);
    }

    public function getUsers() 
    {
        $users = User::all();
        return $users;
    }
}
