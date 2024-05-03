<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    /**
     * @OA\Post(
     *     path="/api/auth/signup",
     *     summary="User Registration API",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="Password Confirmation",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function signup(SignUpRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();
        // Create a new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'points' => 100,
            'password' => bcrypt($validatedData['password']),
        ]);


        $token = $user->createToken('UserAuth')->accessToken;

        return response()->json(['message' => 'User signed up successfully', 'user' => $user, 'accessToken' => $token]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/signin",
     *     summary="Authenticate user and generate JWT token",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function signin(SignInRequest $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            // Authentication successful
            $user = Auth::user();
            $token = $user->createToken('UserAuth')->accessToken;

            return response()->json(['message' => 'User signed in successfully', 'user' => $user, 'accessToken' => $token]);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function profile()
    {
        $user = request()->user();
        return response()->json(['user' => $user]);
    }
}
