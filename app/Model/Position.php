<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
