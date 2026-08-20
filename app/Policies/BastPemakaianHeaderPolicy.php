<?php

namespace App\Policies;

use App\Models\BastPemakaianHeader;
use App\Models\User;

class BastPemakaianHeaderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, BastPemakaianHeader $bast): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, BastPemakaianHeader $bast): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, BastPemakaianHeader $bast): bool
    {
        return $user->role === 'admin';
    }
}