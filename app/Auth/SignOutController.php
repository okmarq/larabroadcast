<?php

namespace App\Auth;

use App\Domain\User\UserRepository;
use App\Domain\User\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SignOutController extends Controller
{
    public function signOut()
    {
        $user = auth()->user();

        $user->tokens()->delete();

        broadcast(new UserOnlineStatusChanged($user))->toOthers();

        return response([
            'message' => 'Signed out'
        ], 200);
    }
}
