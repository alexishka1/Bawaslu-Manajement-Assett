<?php

namespace App\Policies;

use App\Models\ConfigTemplate;
use App\Models\User;

class ConfigTemplatePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, ConfigTemplate $config): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, ConfigTemplate $config): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, ConfigTemplate $config): bool
    {
        return $user->role === 'admin';
    }
}
