<?php

namespace App\Domain\User;

use App\Auth\SignUpRequest;

class UserRepository
{
    public function create(SignUpRequest $request): User
    {
        return User::create($request->all());
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
