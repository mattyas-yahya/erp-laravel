<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccountSubType;
use App\Models\ChartOfAccountType;
use Illuminate\Http\Request;

class ChartOfAccountSubTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('manage constant chart of account sub type'))
        {
            $subtypes = ChartOfAccountSubType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('chartOfAccountSubType.index', compact('subtypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ChartOfAccountType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        return view('chartOfAccountSubType.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('create constant chart of account sub type'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'type' => 'required',
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $account             = new ChartOfAccountSubType();
            $account->type       = $request->type;
            $account->name       = $request->name;
            $account->created_by = \Auth::user()->creatorId();
            $account->save();

            return redirect()->route('chart-of-account-subtype.index')->with('success', __('Chart of account sub type successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subtypes = ChartOfAccountSubType::find($id);
        $types = ChartOfAccountType::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        return view('chartOfAccountSubType.edit', compact('subtypes','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit constant chart of account sub type'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'type' => 'required',
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $chartOfAccountType = ChartOfAccountSubType::find($id);
            $chartOfAccountType->type = $request->type;
            $chartOfAccountType->name = $request->name;
            $chartOfAccountType->save();

            return redirect()->route('chart-of-account-subtype.index')->with('success', __('Chart of account sub type successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\Auth::user()->can('delete constant chart of account sub type'))
        {
            ChartOfAccountSubType::where('id',$id)->delete();

            return redirect()->route('chart-of-account-subtype.index')->with('success', __('Chart of account sub type successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
