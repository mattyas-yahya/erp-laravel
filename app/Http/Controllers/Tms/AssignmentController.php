<?php

namespace App\Http\Controllers\Tms;

use App\Domains\Tms\DeliveryWaybillNumberCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tms\AssignmentRequest as TmsAssignmentRequest;
use App\Models\Employee;
use App\Models\Tms\Assignment as TmsAssignment;
use App\Models\Tms\Vehicle as TmsVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    public function __construct()
    {
    }

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $assignments = TmsAssignment::with(['vehicle', 'driver'])->get();

        return view('tms.assignment.index', [
            'assignments' => $assignments,
        ]);
    }

    function create()
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $vehicles = TmsVehicle::all();
        $drivers =  Employee::whereRelation('designation', 'name', 'LIKE', '%' . 'Driver' . '%')
            ->where('created_by', '=', Auth::user()->creatorId())
            ->get();
        $deliveryWaybillNumberCode = DeliveryWaybillNumberCode::create();

        return view('tms.assignment.create', [
            'deliveryWaybillNumberCode' => $deliveryWaybillNumberCode,
            'vehicles' => $vehicles,
            'drivers' => $drivers,
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
            ->where('created_by', '=', Auth::user()->creatorId())
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
                'delivery_order_number' => $request->delivery_order_number,
                'driver_id' => $request->driver_id,
                'started_at' => $request->started_at,
                'starting_odometer' => $request->starting_odometer,
                'last_odometer' => 0,
                'comment' => $request->comment,
            ]);

            DB::commit();

            return redirect()->route('tms.assignment.index')->with('success', __('Assignment successfully created.'));
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

            return redirect()->route('tms.assignment.index')->with('success', __('Assignment successfully updated.'));
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

            return redirect()->route('tms.assignment.index')->with('success', __('Assignment successfully deleted.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }
}
