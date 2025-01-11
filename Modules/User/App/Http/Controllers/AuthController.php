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
use Modules\User\App\Contracts\UserRepositoryInterface;

class AuthController extends Controller
{
    private $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
    ) {
        $this->userRepo = $userRepo;
    }

    // register user
    public function register(Request $request)
    {
        $requestParams = ($request->all());
        $register = $this->userRepo->registerUser($requestParams);
        return $register;
    }

    // login user
    public function login(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Special condition for admin login
        if ($validatedData['user_name'] === 'admin' && $validatedData['password'] === 'admin') {
            // Create a fake user object for admin
            $adminUser = (object) [
                'id' => 0,
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
            ];

            // Generate a token for the admin
            $token = 'admin-token';

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 7200, // 2 hours
                'user' => [
                    'id' => $adminUser->id,
                    'first_name' => $adminUser->first_name,
                    'last_name' => $adminUser->last_name,
                    'email' => $adminUser->email,
                ],
            ]);
        }

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


    //logout user
    public function logout(Request $request)
    {
        // Check if the user is the special 'admin'
        if ($request->bearerToken() === 'admin-token') {
            // Logic for logging out admin
            return response()->json(['message' => 'Admin successfully logged out']);
        }

        // For normal users
        if ($request->user() && $request->user()->token()) {
            $request->user()->token()->revoke();
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
}
