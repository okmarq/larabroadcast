<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function index()
    {
        $cacheKey = 'users';
        $cacheTime = 3600;
        return Cache::remember($cacheKey, $cacheTime, fn () => UserResource::collection(User::all()));
    }
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        return new UserResource($user);
    }

    public function show(User $user)
    {
        $cacheKey = 'user_' . $user->id;
        $cacheTime = 3600;
        return Cache::remember($cacheKey, $cacheTime, function () use ($user) {
            return new UserResource($user);
        });
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response(null, 204);
    }
}
