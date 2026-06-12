<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
            $success['account_type'] =  $user->account_type;
    
            return response()->json($success, 201);
        } 
        else{ 
            return response()->json(['message' => 'Unauthorized'], 401);
        } 
    }

    public function register(StoreUserRequest $request) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->company = $request->company;
        $user->account_type = 'client';
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success'], 201);
    }
}
