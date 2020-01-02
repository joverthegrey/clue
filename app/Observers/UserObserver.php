<?php

namespace App\Observers;

use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public function saving(User $user)
    {
        // as we're misusing register users for our foxes, fill in some missing information

        // set role default to fox
        if (!$user->role_id) {
            $fox_role = Role::where('name', '=', 'fox')->first();
            $user->role()->associate($fox_role);
        }

        // if password not given, generate one
        if (empty($user->password)) {
            $user->password = Hash::make($user->name);
        }

        // if email address not given, generate one based on the name
        if (empty($user->email)) {
            $user->email = base64_encode($user->name . sprintf("%d", time())) . '@example.com';
        }
    }

    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
