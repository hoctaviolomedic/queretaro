<?php

namespace App\Policies;

use App\Http\Models\Administracion\Usuarios;
use Illuminate\Auth\Access\HandlesAuthorization;

class PolicyBase
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(Usuarios $usuario)
    {
        return true;
        return $usuario->checkAuthorization(currentRouteAction('view'));
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(Usuarios $usuario)
    {
        return true;
        return $usuario->checkAuthorization(currentRouteAction('create'));
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(Usuarios $usuario)
    {
        return true;
        return $usuario->checkAuthorization(currentRouteAction('update'));
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(Usuarios $usuario)
    {
        return true;
        return $usuario->checkAuthorization(currentRouteAction('delete'));
    }

    /**
     * Determine whether the user can export the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function export(Usuarios $usuario)
    {
        return true;
        return $usuario->checkAuthorization(currentRouteAction('export'));
    }
}