<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Utility;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class WarningController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage warning'))
        {
            if(Auth::user()->type == 'employee')
            {
                $emp      = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $warnings = Warning::where('warning_by', '=', $emp->id)->get();
            }
            else
            {
                $warnings = Warning::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('warning.index', compact('warnings'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create warning'))
        {
            $user             = \Auth::user();
            $branch = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();
            $branch2 = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('warning.create', compact('branch', 'branch2'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create warning'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'branch_id_from' => 'required',
                                   'department_id_from' => 'required',
                                   'employee_id_from' => 'required',
                                   'branch_id_against' => 'required',
                                   'department_id_against' => 'required',
                                   'employee_id_against' => 'required',
                                   'warning_type' => 'required',
                                   'subject' => 'required',
                                   'warning_date' => 'required',
                               ]
            );

            

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $warning = new Warning();
            $warning->branch_id_from = $request->branch_id_from;
            $warning->department_id_from = $request->department_id_from;
            $warning->employee_id_from = $request->employee_id_from;
            $warning->branch_id_against   = $request->branch_id_against;
            $warning->department_id_against   = $request->department_id_against;
            $warning->employee_id_against   = $request->employee_id_against;
            $warning->warning_type   = $request->warning_type;
            $warning->subject      = $request->subject;
            $warning->warning_date = $request->warning_date;
            $warning->description  = $request->description;
            $warning->created_by   = \Auth::user()->creatorId();
            $warning->save();

            //Send Email

            $setings = Utility::settings();
            if($setings['warning_sent'] == 1)
            {
                $employee       = Employee::find($warning->employee_id_against);
                $warningArr = [
                    'employee_warning_name'=>$employee->name,
                    'warning_subject' =>$warning->subject,
                    'warning_description'  =>$warning->description,
                ];

                $resp = Utility::sendEmailTemplate('warning_sent', [$employee->id => $employee->email], $warningArr);

                return redirect()->route('warning.index')->with('success', __('Warning  successfully created.'). ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));;

            }

            return redirect()->route('warning.index')->with('success', __('Warning  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Warning $warning)
    {
        return redirect()->route('warning.index');
    }

    public function edit(Warning $warning)
    {

        if(\Auth::user()->can('edit warning'))
        {
            if(Auth::user()->type == 'employee')
            {
                $user             = \Auth::user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
                $employees        = Employee::where('user_id', '!=', $user->id)->get()->pluck('name', 'id');
            }
            else
            {
                $branch      = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $branch2      = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $departments = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $departments2 = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $employees       = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $employees2        = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $user             = \Auth::user();
                $current_employee = Employee::where('user_id', $user->id)->get()->pluck('name', 'id');
            }
            if($warning->created_by == \Auth::user()->creatorId())
            {
                return view('warning.edit', compact('warning', 'current_employee', 'branch', 'departments', 'employees', 'branch2', 'departments2', 'employees2'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Warning $warning)
    {
        if(\Auth::user()->can('edit warning'))
        {
            if($warning->created_by == \Auth::user()->creatorId())
            {                
                $validator = \Validator::make(
                    $request->all(), [
                        'warning_type' => 'required',
                        'subject' => 'required',
                        'warning_date' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                // if(\Auth::user()->type == 'employee')
                // {
                //     $emp                 = Employee::where('user_id', '=', \Auth::user()->id)->first();
                //     $warning->warning_by = $emp->id;
                // }
                // else
                // {
                    
                // }
                $warning->branch_id_from = $request->branch_id_from;
                $warning->department_id_from = $request->department_id_from;
                $warning->employee_id_from = $request->employee_id_from;
                $warning->branch_id_against   = $request->branch_id_against;
                $warning->department_id_against   = $request->department_id_against;
                $warning->employee_id_against   = $request->employee_id_against;
                $warning->warning_type   = $request->warning_type;
                $warning->subject      = $request->subject;
                $warning->warning_date = $request->warning_date;
                $warning->description  = $request->description;
                // dd($warning);
                $warning->save();

                return redirect()->route('warning.index')->with('success', __('Warning successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Warning $warning)
    {
        if(\Auth::user()->can('delete warning'))
        {
            if($warning->created_by == \Auth::user()->creatorId())
            {
                $warning->delete();

                return redirect()->route('warning.index')->with('success', __('Warning successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function getdepartment(Request $request)
    {
        $departments['departments'] = Department::where('created_by', '=', \Auth::user()->creatorId())->where('branch_id', $request->branch_id)->get();
        return response()->json($departments);
    }

    public function getemployee(Request $request)
    {
        $employees['employees'] = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('department_id', $request->department_id)->get();
        return response()->json($employees);
    }
}
