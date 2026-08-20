<?php

namespace App\Policies;

use App\Models\RefPegawai;
use App\Models\User;

class RefPegawaiPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, RefPegawai $pegawai): bool
    {
        return $user->role === 'admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, RefPegawai $pegawai): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, RefPegawai $pegawai): bool
    {
        return $user->role === 'admin';
    }
}