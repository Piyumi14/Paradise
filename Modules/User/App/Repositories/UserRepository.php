<?php

namespace Modules\User\App\Repositories;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;
use App\Repositories\MainRepository;
use App\Models\User;
use App\Models\UserCredential;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\User\App\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class UserRepository extends MainRepository implements UserRepositoryInterface
{
    protected $app;
    public function __construct(Container $app)
    {
        $this->app = $app; // Store the container instance
    }

    /**
     * Get the model associated with the repository.
     *
     * @return string The fully qualified class name of the model.
     */
    function model()
    {
        return 'App\Models\User';
    }

    public function createUserDetails(array $requestParams)
    {
        return User::create($requestParams);
    }

    public function createUserCredentialDetails(array $requestParams)
    {
        return UserCredential::create($requestParams);
    }

    public function registerUser(array $requestParams)
    {
        // Validate the incoming request data
        $validator = Validator::make($requestParams, [
            'user_name' => 'required|string|max:100|unique:user_credentials', // Validate username as unique
            'first_name' => 'required|string|max:100', // Validate first name
            'last_name' => 'required|string|max:100', // Validate last name
            'email' => 'required|string|email|max:255|unique:users', // Validate email as unique
            'phone_number' => 'required', // Validate phone number 
            'password' => 'required|string', // Validate password 
            'gender' => 'required|string', // Validate gender 
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
                'gender' => $validatedData['gender'],
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
}
