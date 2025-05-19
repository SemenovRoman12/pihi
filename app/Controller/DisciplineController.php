<?php

namespace Controller;

use Src\Validation\DisciplineValidator;
use Model\Discipline;
use Src\Request;
use Src\View;

class DisciplineController
{
    /** Список дисциплин */
    public function index(): string
    {
        return (new View())->render('disciplines.index', [
            'disciplines' => Discipline::all(),
        ]);
    }

    /** Создание дисциплины */
    public function create(Request $r): string
    {
        if ($r->method === 'POST') {
            $validator = new DisciplineValidator();

            if ($validator->validate([
                'name'  => $r->get('name'),
                'hours' => $r->get('hours'),
            ])) {
                Discipline::create([
                    'name'  => $r->get('name'),
                    'hours' => $r->get('hours'),
                ]);
                app()->route->redirect('/disciplines');
            }

            // ----- ошибка валидации: возвращаем форму с ошибками и введёнными данными
            return (new View())->render('disciplines.form', [
                'errors' => $validator->errors(),
                'old'    => [
                    'name'  => $r->get('name'),
                    'hours' => $r->get('hours'),
                ],
            ]);
        }

        return (new View())->render('disciplines.form');
    }

    /** Редактирование дисциплины */
    public function edit(Request $r): string
    {
        $d = Discipline::findOrFail($r->get('id'));

        if ($r->method === 'POST') {
            $validator = new DisciplineValidator();

            if ($validator->validate([
                'id'    => $d->id,
                'name'  => $r->get('name'),
                'hours' => $r->get('hours'),
            ])) {
                $d->update([
                    'name'  => $r->get('name'),
                    'hours' => $r->get('hours'),
                ]);
                app()->route->redirect('/disciplines');
            }

            // ----- ошибка валидации
            return (new View())->render('disciplines.form', [
                'errors'     => $validator->errors(),
                'discipline' => $d,        // чтобы отличать режим edit
                'old'        => [
                    'name'  => $r->get('name'),
                    'hours' => $r->get('hours'),
                ],
            ]);
        }

        return (new View())->render('disciplines.form', ['discipline' => $d]);
    }

    public function delete(Request $r): void
    {
        if ($d = Discipline::find($r->get('id'))) {
            $d->delete();
        }
        app()->route->redirect('/disciplines');
    }
}
