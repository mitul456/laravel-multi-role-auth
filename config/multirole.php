<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Role Configuration
    |--------------------------------------------------------------------------
    */
    'default_role' => env('DEFAULT_ROLE', 'User'),
    'default_role_id' => env('DEFAULT_ROLE_ID', null),

    /*
    |--------------------------------------------------------------------------
    | Role to Guard Mapping
    |--------------------------------------------------------------------------
    */
    'guard_mapping' => [
        'web' => ['User', 'Editor', 'Moderator', 'Admin', 'SuperAdmin'],
        'admin' => ['Admin', 'SuperAdmin'],
        'api' => ['User', 'Editor', 'Moderator', 'Admin', 'SuperAdmin'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirect Paths Per Role
    |--------------------------------------------------------------------------
    */
    'redirect_paths' => [
        'SuperAdmin' => '/superadmin/dashboard',
        'Admin' => '/admin/dashboard',
        'Moderator' => '/moderator/dashboard',
        'Editor' => '/editor/dashboard',
        'User' => '/user/dashboard',
        'default' => '/dashboard',
    ],

    /*
    |--------------------------------------------------------------------------
    | Home Routes Per Role
    |--------------------------------------------------------------------------
    */
    'home_routes' => [
        'SuperAdmin' => 'superadmin.home',
        'Admin' => 'admin.home',
        'Moderator' => 'moderator.home',
        'Editor' => 'editor.home',
        'User' => 'user.home',
        'default' => 'home',
    ],

    /*
    |--------------------------------------------------------------------------
    | Role Hierarchy (Higher priority overrides lower)
    |--------------------------------------------------------------------------
    */
    'role_hierarchy' => [
        'SuperAdmin',
        'Admin',
        'Moderator',
        'Editor',
        'User',
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware Aliases
    |--------------------------------------------------------------------------
    */
    'middleware_aliases' => [
        'role' => \Mitul456\LaravelMultiRoleAuth\Middleware\RoleMiddleware::class,
        'role.or' => \Mitul456\LaravelMultiRoleAuth\Middleware\RoleOrMiddleware::class,
        'role.api' => \Mitul456\LaravelMultiRoleAuth\Http\Middleware\RoleApiMiddleware::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => env('ROLE_CACHE_ENABLED', true),
        'ttl' => env('ROLE_CACHE_TTL', 3600),
        'key' => 'laravel_multirole_cache',
    ],
];