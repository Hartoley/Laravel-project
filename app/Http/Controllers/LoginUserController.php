<?php

namespace App\Http\Controllers;

use App\Models\LoginUser; // Ensure this model has the necessary fields
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginUserController extends Controller
{
    // Method to handle user registration
    public function LoginUser(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email|unique:login_users,email', // Ensure email is unique
            'surname' => 'required|string',
            'first_name' => 'required|string',
            'password' => 'required|string|min:6', // Ensure password is at least 6 characters
        ]);

        // Create a new user
        LoginUser::create([
            'email' => $request->input('email'),
            'surname' => $request->input('surname'),
            'first_name' => $request->input('first_name'),
            'password' => Hash::make($request->input('password')), // Hash the password
            'role' => 'user', // Set a default role or handle it as needed
        ]);

        return response()->json(["message" => "Registration successful"], 201);
    }

    // Method to handle user sign-in
    public function signIn(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Retrieve the credentials from the request
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt($credentials)) {
            // If authentication is successful, retrieve the authenticated user
            $user = Auth::user();

            // Return a JSON response with user information, including the role
            return response()->json([
                'success' => true,
                'message' => 'Sign-in successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name, // Assuming you have these fields
                    'email' => $user->email,
                    'role' => $user->role, // Include the role
                ],
            ], 200);
        }

        // If authentication fails, return an error response
        return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
    }
}
