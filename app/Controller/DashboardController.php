<?php

namespace Controller;

use Model\Employee;
use Model\Department;
use Model\Discipline;
use Src\View;

class DashboardController
{
    /**
     * Пустая «главная» страница: выводим счётчики записей.
     */
    public function index(): string
    {
        return (new View())->render('dashboard.index', [
            'employeesCount'   => Employee::count(),
            'departmentsCount' => Department::count(),
            'disciplinesCount' => Discipline::count(),
        ]);
    }
}
