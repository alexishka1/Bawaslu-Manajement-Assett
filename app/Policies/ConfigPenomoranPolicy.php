<?php

namespace App\Policies;

use App\Models\ConfigPenomoran;
use App\Models\User;

class ConfigPenomoranPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, ConfigPenomoran $config): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, ConfigPenomoran $config): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, ConfigPenomoran $config): bool
    {
        return $user->role === 'admin';
    }
}
