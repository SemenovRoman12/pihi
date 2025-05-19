<?php

use Src\Route;

/* ------------ АУТЕНТИФИКАЦИЯ ------------- */
Route::add(['GET','POST'],'/login',  [Controller\Site::class,'login']);
Route::add('GET',          '/logout', [Controller\Site::class,'logout']);

/* ------------ ДАШБОРД ------------- */
Route::add('GET', '/', [Controller\DashboardController::class,'index'])
    ->middleware('auth');

/* ------------ СОТРУДНИКИ ------------- */
Route::add('GET', '/employees', [Controller\EmployeeController::class,'index'])
    ->middleware('auth');
Route::add(['GET','POST'], '/employee/create',[Controller\EmployeeController::class,'create'])
    ->middleware('role:staff');
Route::add(['GET','POST'], '/employee/edit',  [Controller\EmployeeController::class,'edit'])
    ->middleware('role:staff');
Route::add('GET', '/employee/delete', [Controller\EmployeeController::class,'delete'])
    ->middleware('role:admin');

/* ------------ КАФЕДРЫ ------------- */
Route::add('GET','/departments',[Controller\DepartmentController::class,'index'])
    ->middleware('auth');
Route::add(['GET','POST'],'/department/create',[Controller\DepartmentController::class,'create'])
    ->middleware('role:staff');
Route::add(['GET','POST'],'/department/edit',  [Controller\DepartmentController::class,'edit'])
    ->middleware('role:staff');
Route::add('GET','/department/delete',[Controller\DepartmentController::class,'delete'])
    ->middleware('role:admin');

/* ------------ ДИСЦИПЛИНЫ ------------- */
Route::add('GET','/disciplines',[Controller\DisciplineController::class,'index'])
    ->middleware('auth');
Route::add(['GET','POST'],'/discipline/create',[Controller\DisciplineController::class,'create'])
    ->middleware('role:staff');
Route::add(['GET','POST'],'/discipline/edit',  [Controller\DisciplineController::class,'edit'])
    ->middleware('role:staff');
Route::add('GET','/discipline/delete',[Controller\DisciplineController::class,'delete'])
    ->middleware('role:admin');
