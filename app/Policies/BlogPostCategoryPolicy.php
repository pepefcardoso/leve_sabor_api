<?php

namespace App\Policies;

use App\Models\User;

class BlogPostCategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user)
    {
        return $user->isAdmin();
    }

    public function delete(User $user)
    {
        return $user->isAdmin();
    }

    public function restore(User $user)
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user)
    {
        return $user->isAdmin();
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user)
    {
        return true;
    }
}
