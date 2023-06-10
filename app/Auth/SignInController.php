<?php

namespace App\Auth;

use App\Domain\User\UserRepository;
use App\Domain\User\UserResource;
use App\Events\UserOnlineStatusChanged;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class SignInController extends Controller
{
    /**
     * @throws AuthenticationException
     */
    public function signIn(SignInRequest $request)
    {
        if (Auth::attempt($request->all())) {
            $user = (new UserRepository)->findByEmail($request['email']);
            $token = $user->createToken('SignIn')->plainTextToken;
            $user->setOnlineStatus(true);

//            broadcast(new UserOnlineStatusChanged($user))->toOthers();
            Broadcast::channel('user.'.$user->id, function ($user) {
                return $user;
            });

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
