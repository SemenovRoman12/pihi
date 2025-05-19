<?php

namespace Controller;

use Model\Department;
use Src\Request;
use Src\View;
use Src\Validation\DepartmentValidator;

class DepartmentController
{
    /** Список кафедр */
    public function index(): string
    {
        return (new View())->render('departments.index', [
            'departments' => Department::all(),
        ]);
    }

    /** Создание кафедры */
    public function create(Request $r): string
    {
        if ($r->method === 'POST') {
            $validator = new DepartmentValidator();

            if ($validator->validate(['name' => $r->get('name')])) {
                Department::create(['name' => $r->get('name')]);
                app()->route->redirect('/departments');
            }

            return (new View())->render('departments.form', [
                'errors' => $validator->errors(),
            ]);
        }

        return new View('departments.form');
    }

    /** Редактирование кафедры */
    public function edit(Request $r): string
    {
        $dep = Department::findOrFail($r->get('id'));

        if ($r->method === 'POST') {
            $validator = new DepartmentValidator();

            if ($validator->validate([
                'id'   => $dep->id,
                'name' => $r->get('name'),
            ])) {
                $dep->update(['name' => $r->get('name')]);
                app()->route->redirect('/departments');
            }

            return (new View())->render('departments.form', [
                'errors'     => $validator->errors(),
                'department' => $dep,
            ]);
        }

        return (new View())->render('departments.form', ['department' => $dep]);
    }
    public function delete(Request $r): void
    {
        if ($d = Department::find($r->get('id'))) {
            $d->delete();
        }
        app()->route->redirect('/departments');
    }
}
