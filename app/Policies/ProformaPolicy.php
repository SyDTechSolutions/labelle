<?php

namespace App\Policies;

use App\User;
use App\Proforma;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProformaPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }
    /**
     * Determine whether the user can view the proforma.
     *
     * @param  \App\User  $user
     * @param  \App\Proforma  $proforma
     * @return mixed
     */
    public function view(User $user, Proforma $proforma)
    {
        //
    }

    /**
     * Determine whether the user can create proformas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the proforma.
     *
     * @param  \App\User  $user
     * @param  \App\Proforma  $proforma
     * @return mixed
     */
    public function update(User $user, Proforma $proforma)
    {
        return $user->hasRole('vendedor');
    }

    /**
     * Determine whether the user can delete the proforma.
     *
     * @param  \App\User  $user
     * @param  \App\Proforma  $proforma
     * @return mixed
     */
    public function delete(User $user, Proforma $proforma)
    {
        //
    }
}
