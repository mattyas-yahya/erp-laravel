<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Holiday;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{

    public function index(Request $request)
    {
        if(\Auth::user()->can('manage holiday'))
        {
            if(Auth::user()->type == 'company')
            {
                $holidays = Holiday::where('created_by', '=', \Auth::user()->creatorId());

                if(!empty($request->start_date))
                {
                    $holidays->where('date', '>=', $request->start_date);
                }
                if(!empty($request->end_date))
                {
                    $holidays->where('date', '<=', $request->end_date);
                }
                $holidays = $holidays->get();
            }
            else
            {
                $holidays = Holiday::where('branch_id',Auth::user()->employee->branch_id)->where('created_by', '=', \Auth::user()->creatorId());

                if(!empty($request->start_date))
                {
                    $holidays->where('date', '>=', $request->start_date);
                }
                if(!empty($request->end_date))
                {
                    $holidays->where('date', '<=', $request->end_date);
                }
                $holidays = $holidays->get();
            }

            return view('holiday.index', compact('holidays'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }


    public function create()
    {
        if(\Auth::user()->can('create holiday'))
        {
            if(Auth::user()->type == 'company')
            {
                $branch = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();
            }else{
                $branch = Branch::where('id', \Auth::user()->employee->branch_id)->where('created_by', '=', \Auth::user()->creatorId())->get();
            }
            
            return view('holiday.create', compact('branch'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create holiday'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'date' => 'required',
                                   'occasion' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $holiday             = new Holiday();
            $holiday->branch_id     = $request->branch_id;
            $holiday->department_id = $request->department_id;
            $holiday->date       = $request->date;
            $holiday->end_date     = $request->end_date;
            $holiday->occasion   = $request->occasion;
            $holiday->created_by = \Auth::user()->creatorId();
            $holiday->save();

            //Slack Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            if(isset($setting['holiday_notification']) && $setting['holiday_notification'] ==1){
                $msg = $request->occasion.' '.__("holiday on").' '.$request->date. '.';
                Utility::send_slack_msg($msg);
            }

            //Telegram Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            if(isset($setting['telegram_holiday_notification']) && $setting['telegram_holiday_notification'] ==1){
                $msg = $request->occasion.' '.__("holiday on").' '.$request->date. '.';
                Utility::send_telegram_msg($msg);
            }

            return redirect()->route('holiday.index')->with('success', 'Holiday successfully created.');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }


    public function show(Holiday $holiday)
    {
        //
    }


    public function edit(Holiday $holiday)
    {
        if(\Auth::user()->can('edit holiday'))
        {
            $branch      = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $departments = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            return view('holiday.edit', compact('branch','departments'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }


    public function update(Request $request, Holiday $holiday)
    {
        if(\Auth::user()->can('edit holiday'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'date' => 'required',
                                   'occasion' => 'required',
                               ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $holiday->branch_id     = $request->branch_id;
            $holiday->department_id = $request->department_id;
            $holiday->date     = $request->date;
            $holiday->end_date       = $request->end_date;
            $holiday->occasion = $request->occasion;
            $holiday->save();

            return redirect()->route('holiday.index')->with(
                'success', 'Holiday successfully updated.'
            );
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }


    public function destroy(Holiday $holiday)
    {
        if(\Auth::user()->can('delete holiday'))
        {
            $holiday->delete();

            return redirect()->route('holiday.index')->with(
                'success', 'Holiday successfully deleted.'
            );
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }

    public function calender(Request $request)
    {

        if(\Auth::user()->can('manage holiday'))
        {
            $transdate = date('Y-m-d', time());

            $holidays = Holiday::where('created_by', '=', \Auth::user()->creatorId());

            if(!empty($request->start_date))
            {
                $holidays->where('date', '>=', $request->start_date);
            }
            if(!empty($request->end_date))
            {
                $holidays->where('date', '<=', $request->end_date);
            }



            $holidays = $holidays->get();

            $arrHolidays = [];

            foreach($holidays as $holiday)
            {
                $arr['id']        = $holiday['id'];
                $arr['title']     = $holiday['occasion'];
                $arr['start']     = $holiday['date'];
                $arr['end']       = $holiday['end_date'];
                $arr['className'] = 'event-primary';
                $arr['url']       = route('holiday.edit', $holiday['id']);
                $arrHolidays[]    = $arr;
            }
            $arrHolidays = str_replace('"[', '[', str_replace(']"', ']', json_encode($arrHolidays)));


            return view('holiday.calender', compact('arrHolidays','transdate','holidays'));
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
}
