<?php

use Middlewares\AuthMiddleware;
use Middlewares\RoleMiddleware;
use Src\Auth\Auth;

return [
    'auth'     => Auth::class,
    'identity' => \Model\User::class,
    'routeMiddleware' => [
        'auth' => AuthMiddleware::class,
        'role' => RoleMiddleware::class,
    ],
];
