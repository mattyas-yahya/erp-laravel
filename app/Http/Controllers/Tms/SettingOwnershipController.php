<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Tms\Ownership as TmsOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingOwnershipController extends Controller
{
    public function __construct()
    {
    }

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $ownerships = TmsOwnership::all();

        return view('tms.setting.ownership.index', [
            'ownerships' => $ownerships,
        ]);
    }

    function create()
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        return view('tms.setting.ownership.create');
    }

    function edit($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $ownership = TmsOwnership::find($id);

        return view('tms.setting.ownership.edit', [
            'ownership' => $ownership ?? [],
        ]);
    }

    function store(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            TmsOwnership::create([
                'name' => $request->name,
            ]);

            DB::commit();

            return redirect()->route('tms.setting.ownership.index')->with('success', __('Master ownership successfully created.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function update(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $ownership = TmsOwnership::findOrFail($id);
            $ownership->fill($request->all());
            $ownership->save();

            DB::commit();

            return redirect()->route('tms.setting.ownership.index')->with('success', __('Master ownership successfully updated.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function destroy($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $ownership = TmsOwnership::find($id);
            $ownership->delete();

            DB::commit();

            return redirect()->route('tms.setting.ownership.index')->with('success', __('Master ownership successfully deleted.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }
}
