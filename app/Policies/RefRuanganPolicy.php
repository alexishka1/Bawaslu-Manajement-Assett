<?php

namespace App\Policies;

use App\Models\RefRuangan;
use App\Models\User;

class RefRuanganPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isStaff();
    }

    public function view(User $user, RefRuangan $ruangan): bool
    {
        return $user->isAdmin() || $user->isStaff();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, RefRuangan $ruangan): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, RefRuangan $ruangan): bool
    {
        return $user->isAdmin();
    }
}
