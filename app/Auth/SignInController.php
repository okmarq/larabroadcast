<?php

namespace App\Auth;

use App\Domain\User\UserRepository;
use App\Domain\User\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SignInController extends Controller
{
    public function signIn(SignInRequest $request)
    {
        if (Auth::attempt($request)) {
            $user = (new UserRepository)->findByEmail($request['email']);
            $token = $user->createToken('SignIn')->plainTextToken;
            $user->setOnlineStatus(true);

            broadcast(new UserOnlineStatusChanged($user))->toOthers();

            return response([
                'user' => new UserResource($user),
                'token' => $token,
                'message' => 'Authenticated successfully'
            ], 200);
//            return response()->json(['message' => 'Authenticated successfully']);
        }

        throw new AuthenticationException(
            'Invalid credentials'
        );
//        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
