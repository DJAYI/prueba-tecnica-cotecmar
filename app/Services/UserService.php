<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function getAllUsers(): Collection
    {
        return User::all();
    }

    public function getUserById(int $id): ?User
    {
        if (!$id) {
            return null;
        }
        return User::find($id);
    }

    public function createUser(array $data): User
    {
        return User::create($data);
    }

    public function updateUser(User $User, array $data): bool
    {
        return $User->update($data);
    }

    public function deleteUser(int $id): ?bool
    {
        $User = User::find($id);
        if (!$User) {
            return null;
        }
        return $User->delete();
    }
}
