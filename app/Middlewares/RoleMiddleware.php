<?php
/**
 * Middleware: проверка роли пользователя.
 *
 * Пример использования в маршруте:
 *   Route::add('GET', '/employees/create', [...])->middleware('role:staff');
 *
 *  • Если параметр не указан  -> пропускает всех авторизованных.
 *  • Если указан 'staff'      -> пропускает staff-пользователей и admin.
 *  • Если указан 'admin'      -> пропускает только admin.
 *  • Неавторизованных всегда отправляет на /login.
 */

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class RoleMiddleware
{
    /**
     * @param Request     $request
     * @param string|null $neededRole  значение из маршрута ('admin' | 'staff' | null)
     */
    public function handle(Request $request, string $neededRole = null): void
    {
        /*----- авторизация обязательна -----*/
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }

        /*----- если роль не задана — достаточно факта авторизации -----*/
        if ($neededRole === null) {
            return;
        }

        $userRole = Auth::user()->role;

        /*----- admin имеет полный доступ -----*/
        if ($userRole === 'admin') {
            return;
        }

        /*----- иначе сверяемся с требуемой ролью -----*/
        if ($userRole !== $neededRole) {
            // нет прав  →  на главную (можно заменить на 403)
            app()->route->redirect('/');
        }
    }
}
