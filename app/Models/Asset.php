<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'employee_id',
        'branch_id',
        'department_id',
        'name',
        'purchase_date',
        'supported_date',
        'amount',
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
    
    public function employees()
    {
        // return $this->belongsToMany('App\Models\Employee', 'employees', '', 'user_id');
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id')->first();
    }

    public function users($users)
    {
        $userArr = explode(',', $users);
        $users  = [];
        foreach($userArr as $user)
        {
            $emp=Employee::where('user_id',$user)->first();

            if(!empty($emp)){
                $users[] = User::where('id',$emp->user_id)->first();
            }

        }
        return $users;
    }

}
