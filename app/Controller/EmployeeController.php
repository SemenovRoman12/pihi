<?php

namespace Controller;

use Model\Employee;
use Model\Department;
use Model\Discipline;
use Model\Position;
use Model\User;
use Src\Request;
use Src\View;
use Src\Validation\UserValidator;

class EmployeeController
{
    public function index(Request $r): string
    {
        $q = Employee::with(['departments', 'disciplines', 'position']);

        /* ---------- фильтр кафедр ---------- */
        if ($ids = $r->get('department')) {
            $q->whereHas('departments',
                fn ($d) => $d->whereIn('departments.id', (array)$ids));
        }

        /* ---------- фильтр дисциплин ---------- */
        if ($ids = $r->get('discipline')) {
            $q->whereHas('disciplines',
                fn ($d) => $d->whereIn('disciplines.id', (array)$ids));
        }

        /* ---------- поиск по ФИО ---------- */
        if ($fio = trim($r->get('fio'))) {
            $like = '%' . $fio . '%';
            $q->where(function ($q) use ($like) {
                $q->whereRaw("CONCAT(last_name,' ',first_name,' ',middle_name) LIKE ?", [$like])
                    ->orWhere('last_name',  'LIKE', $like)
                    ->orWhere('first_name', 'LIKE', $like)
                    ->orWhere('middle_name','LIKE', $like);
            });
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

            /* --- валидируем учётную запись сотрудника --- */
            $validator = new UserValidator();
            $fio = trim(
                ($r->get('last_name') ?? '') . ' ' .
                ($r->get('first_name') ?? '') . ' ' .
                ($r->get('middle_name') ?? '')
            );

            if (!$validator->validate([
                'fio'        => $fio,
                'birth_date' => $r->get('birth_date'),
                'login'      => $r->get('login'),
                'password'   => $r->get('password'),
            ])) {
                // возвращаем форму с ошибками и введёнными данными
                return (new View())->render('employees/form', [
                    'errors'      => $validator->errors(),
                    'old'         => $r->all(),
                    'departments' => Department::all(),
                    'disciplines' => Discipline::all(),
                    'positions'   => Position::all(),
                ]);
            }

            /* --- учётка --- */
            $user = User::create([
                'login'    => $r->get('login'),
                'password' => md5($r->get('password')),
                'role'     => 'staff',
            ]);

            /* --- карточка сотрудника --- */
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

            /* --- назначения --- */
            $emp->departments()->sync($r->get('department', []));
            $emp->disciplines()->sync($r->get('discipline',  []));

            return app()->route->redirect('/');
        }

        /* ---------- GET: пустая форма ---------- */
        return (new View())->render('employees/form', [
            'departments' => Department::all(),
            'disciplines' => Discipline::all(),
            'positions'   => Position::all(),
        ]);
    }

    public function edit(Request $r): string
    {
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

            app()->route->redirect('/employees');
        }

        /* ---------- GET: форма с заполненными полями ---------- */
        return (new View())->render('employees/form', [
            'employee'    => $emp,
            'departments' => Department::all(),
            'disciplines' => Discipline::all(),
            'positions'   => Position::all(),
        ]);
    }
}
