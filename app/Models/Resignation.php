<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    protected $fillable = [
        'employee_id',
        'branch_id',
        'department_id',
        'notice_date',
        'resignation_date',
        'description',
        'created_by',
    ];

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id')->first();
    }

    public function department()
    {
        return $this->hasMany('App\Models\Department', 'id', 'department_id')->first();
    }

    public function branch()
    {
        return $this->hasMany('App\Models\Branch', 'id', 'branch_id')->first();
    }
}
