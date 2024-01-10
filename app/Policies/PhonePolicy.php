<?php

namespace App\Policies;

use App\Models\Phone;
use App\Models\User;

class PhonePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Phone $phone): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Phone $phone): bool
    {
        $contact = $phone->contact;
        $business = $contact->business;

        return $user->business->id === $business->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Phone $phone): bool
    {
        $contact = $phone->contact;
        $business = $contact->business;

        return $user->business->id === $business->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Phone $phone): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Phone $phone): bool
    {
        //
    }
}
