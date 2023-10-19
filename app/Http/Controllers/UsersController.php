<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\SignInRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(): JsonResponse
    {
        $users = $this->user->all();

        if (!$users) {
            $response = [
                'error' => true,
                'message' => 'No users found!'
            ];

            return response()->json($response);
        }

        return response()->json(['users' => $users]);
    }

    public function findOne(Request $request): JsonResponse
    {
        $user = $this->user->find($request->id);

        if (!$user) {
            $response = [
                'error' => true,
                'message' => 'No user was found with the id '.$request->id.'.'
            ];

            return response()->json(['data' => $response]);
        }

        return response()->json([
            'error' => false,
            'product' => $user->product,
            'user' => $user
        ]);
    }

    public function signUp(CreateUserRequest $request): JsonResponse
    {
        $data = $request->only(['first_name', 'last_name', 'email', 'password', 'phone_number', 'birth_date', 'document']);
        $data['password'] = Hash::make($data['password']);

        $user = $this->user->create($data);

        $response = [
            'error' => false,
            'message' => 'User entered successfully!',
            'token' => $user->createToken('Register_token')->plainTextToken
        ];

        return response()->json($response);
    }

    public function signIn(SignInRequest $request): JsonResponse
    {
        $data = $request->only(['email', 'password']);

        if (Auth::attempt($data)) {
            $user = Auth::user();

            $response = [
                'error' => false,
                'token' => $user->createToken('Login_token')->plainTextToken,
                'user' => $user
            ];

            return response()->json($response);
        }

        return response()->json([
            'error' => true,
            'message' => 'Invalid Username and/or Password!'
        ]);
    }

    public function update(CreateUserRequest $request): JsonResponse
    {
        $data = $request->only(['first_name', 'last_name', 'email', 'password', 'phone_number', 'birth_date', 'document']);
        $data['password'] = Hash::make($data['password']);

        $user = $this->user->find($request->id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'The user was not updated because the id was not found!'
            ]);
        }

        $user->update($data);
        $user->save();

        $response = [
            'error' => false,
            'message' => 'The user has been updated successfully!',
            'user' => $user
        ];

        return response()->json($response);
    }

    public function delete(Request $request): JsonResponse
    {
        $user = $this->user->find($request->id);

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'The user with the id '.$request->id.' was not deleted because the id was not found!'
            ]);
        }

        $user->delete();

        $response = [
            'error' => false,
            'message' => 'The user with the id '.$request->id.' has been successfully deleted!',
            'user' => $user
        ];

        return response()->json(['data' => $response]);
    }
}
