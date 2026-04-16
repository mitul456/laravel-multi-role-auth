<?php

if (!function_exists('hasRole')) {
    function hasRole($user, $role)
    {
        return $user && $user->hasRole($role);
    }
}

if (!function_exists('currentUserRole')) {
    function currentUserRole()
    {
        if (auth()->check()) {
            return auth()->user()->getPrimaryRole();
        }
        return null;
    }
}

if (!function_exists('canPerform')) {
    function canPerform($permission)
    {
        return auth()->check() && auth()->user()->can($permission);
    }
}