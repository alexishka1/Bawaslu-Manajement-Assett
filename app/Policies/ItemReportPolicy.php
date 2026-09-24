<?php

namespace App\Policies;

use App\Models\ItemReport;
use App\Models\User;

class ItemReportPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isStaff();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ItemReport $report): bool
    {
        return $user->isAdmin() || $user->id === $report->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isStaff();
    }

    /**
     * Determine whether the user can update the model (validate status).
     */
    public function update(User $user, ItemReport $report): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ItemReport $report): bool
    {
        return $user->isAdmin();
    }
}
