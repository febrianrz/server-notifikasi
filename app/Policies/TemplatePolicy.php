<?php

namespace App\Policies;

use App\User;
use App\Template;
use Illuminate\Auth\Access\HandlesAuthorization;

class TemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list all Templates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the Template.
     *
     * @param  \App\User  $user
     * @param  \App\Template  $template
     * @return mixed
     */
    public function view(User $user, Template $template)
    {
        return true;
    }

    /**
     * Determine whether the user can create Templates.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the Template.
     *
     * @param  \App\User  $user
     * @param  \App\Template  $template
     * @return mixed
     */
    public function update(User $user, Template $template)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the Template.
     *
     * @param  \App\User  $user
     * @param  \App\Template  $template
     * @return mixed
     */
    public function delete(User $user, Template $template)
    {
        return true;
    }
}
