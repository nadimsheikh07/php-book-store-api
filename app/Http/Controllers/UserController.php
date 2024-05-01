<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query();

        // Apply search filter
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // Apply date filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date,
                $request->end_date
            ]);
        }

        // Apply sorting
        $sortColumn = $request->input('sort_column', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $query->orderBy($sortColumn, $sortDirection);

        // Paginate the results
        $pageSize = $request->input('page_size', 10);
        $data = $query->paginate($pageSize);

        return response()->json($data);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        // Validate the incoming request data
        $validatedData = $request->validated();
        // Update the user
        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

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
            'password' => bcrypt($validatedData['password']),
        ]);

        // Optionally, you can automatically sign in the user after signup
        Auth::login($user);

        return response()->json(['message' => 'User signed up successfully', 'user' => $user]);
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

            return response()->json(['message' => 'User signed in successfully', 'user' => $user, 'token' => $token]);
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
