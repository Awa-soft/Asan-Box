<?php

namespace App\Policies\Finance;

use App\Models\User;
use App\Models\Finance\CashManagement;
use Illuminate\Auth\Access\HandlesAuthorization;

class CashManagementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_finance::cash::management');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CashManagement $cashManagement): bool
    {
        return $user->can('view_finance::cash::management');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_finance::cash::management');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CashManagement $cashManagement): bool
    {
        return $user->can('update_finance::cash::management');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CashManagement $cashManagement): bool
    {
        return $user->can('delete_finance::cash::management');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_finance::cash::management');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, CashManagement $cashManagement): bool
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
    public function restore(User $user, CashManagement $cashManagement): bool
    {
        return $user->can('restore_finance::cash::management');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_finance::cash::management');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, CashManagement $cashManagement): bool
    {
        return $user->can('replicate_finance::cash::management');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_finance::cash::management');
    }
}
