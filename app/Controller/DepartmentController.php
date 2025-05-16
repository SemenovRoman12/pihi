<?php

namespace Controller;

use Model\Department;
use Src\Request;
use Src\View;

class DepartmentController
{
    public function index(): string
    {
        return (new View())->render('departments.index', [
            'departments' => Department::all()
        ]);
    }

    public function create(Request $r): string
    {
        if ($r->method === 'POST') {
            Department::create(['name' => $r->get('name')]);
            app()->route->redirect('/departments');
        }
        return new View('departments.form');
    }

    public function edit(Request $r): string
    {
        $dep = Department::findOrFail($r->get('id'));
        if ($r->method === 'POST') {
            $dep->update(['name' => $r->get('name')]);
            app()->route->redirect('/departments');
        }
        return (new View())->render('departments.form', ['department'=>$dep]);
    }
}
