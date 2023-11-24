<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Tms\Assignment as TmsAssignment;
use App\Models\Tms\Vehicle as TmsVehicle;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Tms\AssignmentRequest as TmsAssignmentRequest;

class DeliveryScheduleController extends Controller
{
    public function __construct()
    {
    }

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $assignments = TmsAssignment::with(['vehicle', 'driver', 'details.salesOrderDetail'])->get();
        $vehicles = TmsVehicle::all();

        // dd($assignments);
        // dd($vehicles);

        return view('tms.delivery-schedule.index', [
            'assignments' => $assignments,
            'vehicles' => $vehicles,
        ]);
    }

    function create()
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $assignments = TmsAssignment::with(['vehicle', 'driver'])->get();

        return view('tms.delivery-schedule.create', [
            'assignments' => $assignments,
        ]);
    }

    function edit($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $assignment = TmsAssignment::findOrFail($id);
        $vehicles = TmsVehicle::all();
        $drivers =  Employee::whereRelation('designation', 'name', 'LIKE', '%' . 'Driver' . '%')
            ->where('created_by', '=', \Auth::user()->creatorId())
            ->get();

        return view('tms.assignment.edit', [
            'assignment' => $assignment,
            'vehicles' => $vehicles,
            'drivers' => $drivers,
        ]);
    }

    function store(TmsAssignmentRequest $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            TmsAssignment::create([
                'tms_vehicle_id' => $request->vehicle_id,
                'driver_id' => $request->driver_id,
                'started_at' => $request->started_at,
                'starting_odometer' => $request->starting_odometer,
                'comment' => $request->comment,
            ]);

            DB::commit();

            return redirect()->route('tms.assignment.index')->with('success', __('Vehicle successfully created.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function update(TmsAssignmentRequest $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $assignment = TmsAssignment::findOrFail($id);

            $assignment->fill($request->all());
            $assignment->tms_vehicle_id = $request->vehicle_id;
            $assignment->save();

            DB::commit();

            return redirect()->route('tms.assignment.index')->with('success', __('Vehicle successfully updated.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => 'Update data gagal!']);
        }
    }

    function destroy($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $assignment = TmsAssignment::find($id);
            $assignment->delete();

            DB::commit();

            return redirect()->route('tms.assignment.index')->with('success', __('Vehicle successfully deleted.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }
}
