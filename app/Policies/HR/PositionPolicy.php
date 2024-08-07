<?php

namespace App\Policies\HR;

use App\Models\User;
use App\Models\HR\Position;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_h::r::position');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Position $position): bool
    {
        return $user->can('view_h::r::position');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_h::r::position');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Position $position): bool
    {
        return $user->can('update_h::r::position');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Position $position): bool
    {
        return $user->can('delete_h::r::position');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_h::r::position');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Position $position): bool
    {
        return $user->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Position $position): bool
    {
        return $user->can('restore_h::r::position');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_h::r::position');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Position $position): bool
    {
        return $user->can('replicate_h::r::position');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_h::r::position');
    }
}
