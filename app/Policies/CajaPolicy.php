<?php

namespace App\Policies;

use App\User;
use App\Caja;
use Illuminate\Auth\Access\HandlesAuthorization;

class CajaPolicy
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
     * Determine whether the user can view the caja.
     *
     * @param  \App\User  $user
     * @param  \App\Caja  $caja
     * @return mixed
     */
    public function view(User $user, Caja $caja)
    {
        //
    }

    /**
     * Determine whether the user can create cajas.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the caja.
     *
     * @param  \App\User  $user
     * @param  \App\Caja  $caja
     * @return mixed
     */
    public function update(User $user, Caja $caja)
    {
        dd('s');
        return true; //$user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the caja.
     *
     * @param  \App\User  $user
     * @param  \App\Caja  $caja
     * @return mixed
     */
    public function delete(User $user, Caja $caja)
    {
        //
    }
}
