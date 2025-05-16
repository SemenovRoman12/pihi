<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'first_name','last_name','middle_name','gender',
        'birth_date','address','position_id','user_id'
    ];

    // ---------- relations ----------
    public function user()      { return $this->belongsTo(User::class); }
    public function position()  { return $this->belongsTo(Position::class); }
    public function departments(){ return $this->belongsToMany(Department::class,'employee_department'); }
    public function disciplines(){ return $this->belongsToMany(Discipline::class,'employee_discipline'); }

    // Удобный аксессор ФИО
    public function getFullNameAttribute(): string
    {
        return "{$this->last_name} {$this->first_name} {$this->middle_name}";
    }
}
