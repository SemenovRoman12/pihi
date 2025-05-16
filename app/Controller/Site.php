<?php

namespace Controller;

use Src\Auth\Auth;
use Src\Request;
use Src\View;

class Site
{
    public function login(Request $r): string
    {
        if ($r->method === 'POST') {
            $ok = Auth::attempt([
                'login'    => $r->get('login'),
                'password' => $r->get('password'),
            ]);

            if ($ok) {
                app()->route->redirect('/');
            }

            return (new View())->render('auth/login', [
                'error' => 'Неверный логин или пароль',
            ]);
        }

        return (new View())->render('auth/login');
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }
}
