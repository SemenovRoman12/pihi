<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_department');
    }
}
