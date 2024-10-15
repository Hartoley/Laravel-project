<?php

namespace App\Http\Controllers;

use App\Models\LoginUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginUserController extends Controller
{
    //
    public function LoginUser(Request $request){
        $email =$request->input('email');
        $surname =$request->input('surname');
        $first_name =$request->input('first_name');
        $password =$request->input('password');



        LoginUser::create([
            'email'=> $email,
            'surname'=> $surname,
            'first_name'=> $first_name,
            'password'=> $password,
        ]);

        return response()->json((["message"=> "Reegistration successful", 200]));
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'message' => 'Sign-in successful',
                'user' => $user,
            ], 200);
        }
    
        return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
    }

    
}
