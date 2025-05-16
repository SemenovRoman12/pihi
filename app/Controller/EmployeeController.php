<?php

namespace Controller;

use Model\Employee;
use Model\Department;
use Model\Discipline;
use Model\Position;
use Model\User;
use Src\Request;
use Src\View;

class EmployeeController
{
    public function index(Request $r): string
    {
        $q = Employee::with(['departments', 'disciplines', 'position']);

        /* --- фильтр кафедр --- */
        if ($ids = $r->get('department')) {
            $q->whereHas('departments',
                fn($d) => $d->whereIn('departments.id', (array)$ids));
        }
        /* --- фильтр дисциплин --- */
        if ($ids = $r->get('discipline')) {
            $q->whereHas('disciplines',
                fn($d) => $d->whereIn('disciplines.id', (array)$ids));
        }

        return (new View())->render('employees/index', [
            'employees'   => $q->get(),
            'departments' => Department::all(),
            'disciplines' => Discipline::all(),
        ]);
    }

    /*----------------------------------------------------------------------
     | СОЗДАНИЕ сотрудника
     *---------------------------------------------------------------------*/
    public function create(Request $r): string
    {
        /* ---------- POST: сохраняем ---------- */
        if ($r->method === 'POST') {
            // 1) учётка
            $user = User::create([
                'login'    => $r->get('login'),
                'password' => md5($r->get('password')),
                'role'     => 'staff',
            ]);

            // 2) карточка сотрудника
            $emp = Employee::create([
                'first_name'  => $r->get('first_name'),
                'last_name'   => $r->get('last_name'),
                'middle_name' => $r->get('middle_name'),
                'gender'      => $r->get('gender'),
                'birth_date'  => $r->get('birth_date'),
                'address'     => $r->get('address'),
                'position_id' => $r->get('position_id'),
                'user_id'     => $user->id,
            ]);

            // 3) назначения
            $emp->departments()->sync($r->get('department', []));
            $emp->disciplines()->sync($r->get('discipline', []));

            /* --- редирект на ГЛАВНУЮ --- */
            app()->route->redirect('/');
        }

        /* ---------- GET: форма ---------- */
        return (new View())->render('employees/form', [
            'departments' => Department::all(),
            'disciplines' => Discipline::all(),
            'positions'   => Position::all(),
            // переменной employee НЕТ → шаблон поймёт, что это «создание»
        ]);
    }

    /*----------------------------------------------------------------------
     | РЕДАКТИРОВАНИЕ сотрудника
     *---------------------------------------------------------------------*/
    public function edit(Request $r): string
    {
        /* найдём сотрудника или 404 */
        $emp = Employee::with(['departments', 'disciplines'])
            ->findOrFail($r->get('id'));

        /* ---------- POST: обновляем ---------- */
        if ($r->method === 'POST') {
            $emp->update([
                'first_name'  => $r->get('first_name'),
                'last_name'   => $r->get('last_name'),
                'middle_name' => $r->get('middle_name'),
                'gender'      => $r->get('gender'),
                'birth_date'  => $r->get('birth_date'),
                'address'     => $r->get('address'),
                'position_id' => $r->get('position_id'),
            ]);

            $emp->departments()->sync($r->get('department', []));
            $emp->disciplines()->sync($r->get('discipline', []));

            /* --- редирект на СПИСОК --- */
            app()->route->redirect('/employees');
        }

        /* ---------- GET: форма с заполненными полями ---------- */
        return (new View())->render('employees/form', [
            'employee'    => $emp,               // ← ключ для шаблона
            'departments' => Department::all(),
            'disciplines' => Discipline::all(),
            'positions'   => Position::all(),
        ]);
    }
}
