<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    // protected $fillable = [
    //     'warning_to',
    //     'warning_by',
    //     'subject',
    //     'warning_date',
    //     'description',
    //     'created_by',
    // ];
    protected $guarded = [];

    public function department_from()
    {
        return $this->hasMany('App\Models\Department', 'id', 'department_id_from')->first();
    }

    public function branch_from()
    {
        return $this->hasMany('App\Models\Branch', 'id', 'branch_id_from')->first();
    }

    public function employee_from()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id_from')->first();
    }

    public function department_against()
    {
        return $this->hasMany('App\Models\Department', 'id', 'department_id_against')->first();
    }

    public function branch_against()
    {
        return $this->hasMany('App\Models\Branch', 'id', 'branch_id_against')->first();
    }

    public function employee_against()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id_against')->first();
    }

    // public function employee()
    // {
    //     return $this->hasOne('App\Models\Employee', 'id', 'employee_id')->first();
    // }

    public function warningTo($warningto)
    {
        return Employee::where('id',$warningto)->first();
    }
    public function warningBy($warningby)
    {
        return Employee::where('id',$warningby)->first();
    }
}
