<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'employee_id',
        'branch_id',
        'department_id',
        'branch_id_to',
        'department_id_to',
        'transfer_date',
        'description',
        'created_by',
    ];

    public function department()
    {
        return $this->hasMany('App\Models\Department', 'id', 'department_id')->first();
    }

    public function branch()
    {
        return $this->hasMany('App\Models\Branch', 'id', 'branch_id')->first();
    }

    public function department_to()
    {
        return $this->hasMany('App\Models\Department', 'id', 'department_id_to')->first();
    }

    public function branch_to()
    {
        return $this->hasMany('App\Models\Branch', 'id', 'branch_id_to')->first();
    }

    public function employee()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id')->first();
    }
}
