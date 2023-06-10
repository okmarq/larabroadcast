<?php

namespace App\Auth;

use App\Domain\User\UserRepository;
use App\Domain\User\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request)
    {
        $request->merge(['password' => Hash::make($request['password'])]);
        $user = (new UserRepository)->create($request);
        $token = $user->createToken('SignUp')->plainTextToken;

        return response([
            'user' => new UserResource($user),
            'token' => $token,
            'message' => 'User created successfully'
        ], 201);
    }
}
