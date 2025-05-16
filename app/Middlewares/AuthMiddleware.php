<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class AuthMiddleware
{
    /**
     * Выполняется при каждом запросе к маршруту,
     * помеченному ->middleware('auth')
     *
     * @param Request $request
     */
    public function handle(Request $request): void
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }

    }
}
