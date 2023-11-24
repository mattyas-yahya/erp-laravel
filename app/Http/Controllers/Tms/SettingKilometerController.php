<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Tms\Vehicle as TmsVehicle;
use App\Models\Tms\Kilometer as TmsKilometer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingKilometerController extends Controller
{
    public function __construct()
    {
    }

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $kilometers = TmsKilometer::all();

        return view('tms.setting.kilometer.index', [
            'kilometers' => $kilometers,
        ]);
    }

    function create()
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $vehicles = TmsVehicle::all();

        return view('tms.setting.kilometer.create', [
            'vehicles' => $vehicles,
        ]);
    }

    function edit($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $kilometer = TmsKilometer::find($id);
        $vehicles = TmsVehicle::all();

        return view('tms.setting.kilometer.edit', [
            'kilometer' => $kilometer,
            'vehicles' => $vehicles,
        ]);
    }

    function store(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            TmsKilometer::create([
                'tms_vehicle_id' => $request->tms_vehicle_id,
                'travel_date' => $request->travel_date,
                'travel_kilometers' => $request->travel_kilometers,
            ]);

            DB::commit();

            return redirect()->route('tms.setting.kilometer.index')->with('success', __('Master kilometer successfully created.'));
        } catch (\Throwable $e) {
            dd($e);
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

            $kilometer = TmsKilometer::findOrFail($id);
            $kilometer->fill($request->all());
            $kilometer->save();

            DB::commit();

            return redirect()->route('tms.setting.kilometer.index')->with('success', __('Master kilometer successfully updated.'));
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

            $kilometer = TmsKilometer::find($id);
            $kilometer->delete();

            DB::commit();

            return redirect()->route('tms.setting.kilometer.index')->with('success', __('Master kilometer successfully deleted.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }
}
