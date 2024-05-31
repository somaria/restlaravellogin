<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Helper\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                //hashing the password
                'password' => Hash::make($request->password)

            ]);

            if ($user) {
                return ResponseHelper::success('success', 'User registered successfully', $user, 201);
            }

            return ResponseHelper::error('error', 'User registration failed', [], 400);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseHelper::error('error', $e->getMessage(), [], 400);
        }
    }

    public function userProfile()
    {
        try {
            $user = Auth::user();
            return ResponseHelper::success('success', 'User profile retrieved successfully', $user, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseHelper::error('error', $e->getMessage(), [], 500);
        }
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
    public function login(LoginRequest $request)
    {

        try {


            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return ResponseHelper::error('error', 'Invalid credentials', [], 401);
            }

            /** @var \App\Models\MyUserModel $user **/
            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            $authUser = [
                'user' => $user,
                'token' => $token
            ];

            return ResponseHelper::success('success', 'User logged in successfully', $authUser, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseHelper::error('error', $e->getMessage(), [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
