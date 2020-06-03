<?php

namespace App\Policies;

use App\User;
use App\WebNotification;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebNotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list all WebNotifications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the WebNotification.
     *
     * @param  \App\User  $user
     * @param  \App\WebNotification  $webNotification
     * @return mixed
     */
    public function view(User $user, WebNotification $webNotification)
    {
        return true;
    }

    /**
     * Determine whether the user can create WebNotifications.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the WebNotification.
     *
     * @param  \App\User  $user
     * @param  \App\WebNotification  $webNotification
     * @return mixed
     */
    public function update(User $user, WebNotification $webNotification)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the WebNotification.
     *
     * @param  \App\User  $user
     * @param  \App\WebNotification  $webNotification
     * @return mixed
     */
    public function delete(User $user, WebNotification $webNotification)
    {
        return true;
    }
}
