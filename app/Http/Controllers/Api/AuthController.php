<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Method register
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;

            return Api::setResponse('user', $user);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }


    /**
     * Method login
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return Api::setError('Invalid credentials.');
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $user->token = $token;

            return Api::setResponse('user', $user);
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }


    // User Logout    
    /**
     * Method logout
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return Api::setMessage('Successfully logged out');
        } catch (\Throwable $th) {
            return Api::setError($th->getMessage());
        }
    }
}
