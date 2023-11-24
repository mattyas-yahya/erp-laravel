<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    // protected $fillable = [
    //     'complaint_from',
    //     'complaint_against',
    //     'title',
    //     'complaint_date',
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

    public function complaintFrom($complaint_from)
    {
        return Employee::where('id',$complaint_from)->first();
    }
    public function complaintAgainst($complaint_against)
    {
        return Employee::where('id',$complaint_against)->first();
    }
}
