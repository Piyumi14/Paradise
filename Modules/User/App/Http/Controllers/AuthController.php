<?php

namespace Modules\User\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCredential;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:100|unique:user_credentials', // Validate username as unique
            'first_name' => 'required|string|max:100', // Validate first name
            'last_name' => 'required|string|max:100', // Validate last name
            'email' => 'required|string|email|max:255|unique:users', // Validate email as unique
            'phone_number' => 'required|digits_between:10,15', // Validate phone number with a length range
            'password' => 'required|string|min:8|confirmed', // Validate password with confirmation
        ]);

        // If validation fails, return a JSON response with errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Extract validated data
        $validatedData = $validator->validated();

        // Begin a database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // Create the user record in the users table
            $user = User::create([
                'user_uuid' => Str::uuid(),
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone_number' => $validatedData['phone_number'],
            ]);

            // Create the credentials record in the user_credentials table
            UserCredential::create([
                'user_id' => $user->id, // Reference the newly created user's ID
                'user_name' => $validatedData['user_name'],
                'password' => bcrypt($validatedData['password']), // Hash the password
            ]);

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction in case of any error
            DB::rollBack();

            // Return an error response
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'user_name' => 'required|string', // Validate username instead of email
            'password' => 'required|string',
        ]);

        // Find user credentials by username
        $credentials = UserCredential::where('user_name', $validatedData['user_name'])->first();

        // Check if credentials exist and the password matches
        if (!$credentials || !Hash::check($validatedData['password'], $credentials->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Get the associated user
        $user = $credentials->user;

        // Create an API token for the user
        $token = $credentials->createToken('API Access')->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 7200, // 2 hours
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
