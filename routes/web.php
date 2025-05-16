<?php

use Src\Route;

Route::add(['GET', 'POST'], '/login',  [Controller\Site::class, 'login']);
Route::add('GET',                '/logout', [Controller\Site::class, 'logout']);


Route::add('GET', '/', [Controller\DashboardController::class, 'index'])
    ->middleware('auth');


Route::add('GET', '/employees', [Controller\EmployeeController::class, 'index'])
    ->middleware('auth');


Route::add(['GET', 'POST'], '/employees/create', [Controller\EmployeeController::class, 'create'])
    ->middleware('role:staff');

Route::add(['GET', 'POST'], '/employees/edit',   [Controller\EmployeeController::class, 'edit'])
    ->middleware('role:staff');


Route::add('GET', '/departments', [Controller\DepartmentController::class, 'index'])
    ->middleware('auth');

Route::add(['GET', 'POST'], '/department/create', [Controller\DepartmentController::class, 'create'])
    ->middleware('role:staff');

Route::add(['GET', 'POST'], '/department/edit',   [Controller\DepartmentController::class, 'edit'])
    ->middleware('role:staff');


Route::add('GET', '/disciplines', [Controller\DisciplineController::class, 'index'])
    ->middleware('auth');

Route::add(['GET', 'POST'], '/discipline/create', [Controller\DisciplineController::class, 'create'])
    ->middleware('role:staff');

Route::add(['GET', 'POST'], '/discipline/edit',   [Controller\DisciplineController::class, 'edit'])
    ->middleware('role:staff');
