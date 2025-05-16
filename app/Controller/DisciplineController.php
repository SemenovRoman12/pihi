<?php

namespace Controller;

use Model\Discipline;
use Src\Request;
use Src\View;

class DisciplineController
{
    public function index(): string
    {
        return (new View())->render('disciplines.index', [
            'disciplines' => Discipline::all()
        ]);
    }

    public function create(Request $r): string
    {
        if ($r->method === 'POST') {
            Discipline::create([
                'name'  => $r->get('name'),
                'hours' => $r->get('hours'),   // убедитесь, что hours приходит числом/строкой-числом
            ]);
            app()->route->redirect('/disciplines');
        }
        return new View('disciplines.form');
    }

    public function edit(Request $r): string
    {
        $d = Discipline::findOrFail($r->get('id'));
        if ($r->method === 'POST') {
            $d->update([
                'name'  => $r->get('name'),
                'hours' => $r->get('hours'),
            ]);
            app()->route->redirect('/disciplines');
        }
        return (new View())->render('disciplines.form', ['discipline'=>$d]);
    }
}
