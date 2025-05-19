<?php

use Middlewares\AuthMiddleware;
use Middlewares\CSRFMiddleware;
use Middlewares\RoleMiddleware;
use Middlewares\SpecialCharsMiddleware;
use Middlewares\TrimMiddleware;
use Model\User;
use Src\Auth\Auth;

return [
    'auth'     => Auth::class,
    'identity' => User::class,
    'routeMiddleware' => [
        'trim' => TrimMiddleware::class,
        'auth' => AuthMiddleware::class,
        'role' => RoleMiddleware::class,
        'specialChars' => SpecialCharsMiddleware::class,
        'csrf' => CSRFMiddleware::class,
    ],
];
