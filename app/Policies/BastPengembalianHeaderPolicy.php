<?php

namespace App\Policies;

use App\Models\BastPengembalianHeader;
use App\Models\User;

class BastPengembalianHeaderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, BastPengembalianHeader $bast): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, BastPengembalianHeader $bast): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, BastPengembalianHeader $bast): bool
    {
        return $user->role === 'admin';
    }
}
