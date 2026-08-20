<?php

namespace App\Policies;

use App\Models\RefPejabat;
use App\Models\User;

class RefPejabatPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, RefPejabat $pejabat): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, RefPejabat $pejabat): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, RefPejabat $pejabat): bool
    {
        return $user->role === 'admin';
    }
}