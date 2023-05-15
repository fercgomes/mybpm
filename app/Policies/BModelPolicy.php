<?php

namespace App\Policies;

use App\Models\BModel;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BModelPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BModel $bModel): Response
    {
        return $bModel->owner_id === $user->id ? Response::allow() : Response::deny("You do not own this model.");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BModel $bModel): bool
    {
        return $bModel->owner_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BModel $bModel): bool
    {
        return $bModel->owner_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BModel $bModel): bool
    {
        return $bModel->owner_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BModel $bModel): bool
    {
        return $bModel->owner_id === $user->id;
    }
}