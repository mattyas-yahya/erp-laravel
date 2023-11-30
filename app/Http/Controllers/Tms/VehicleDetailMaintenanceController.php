<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Tms\Vehicle as TmsVehicle;
use App\Models\Tms\VehiclePhysical as TmsVehiclePhysical;
use App\Models\Tms\VehicleDocument as TmsVehicleDocument;
use App\Models\Tms\VehicleMaintenance as TmsVehicleMaintenance;
use App\Models\Tms\VehicleMaintenanceDetail as TmsVehicleMaintenanceDetail;
use App\Models\Tms\Assignment as TmsAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class VehicleDetailMaintenanceController extends Controller
{
    private $countTabs = [
        'vehicleMaintenancesSubmissionCount' => 0,
        'vehicleMaintenancesPlanCount' => 0,
        'vehicleMaintenancesMaintenanceCount' => 0,
        'vehicleMaintenancesFinishedCount' => 0,
    ];
    private $vehicleMaintenancesSubmissionCount;
    private $vehicleMaintenancesPlanCount;
    private $vehicleMaintenancesMaintenanceCount;
    private $vehicleMaintenancesFinishedCount;

    public function __construct()
    {
        $id = Route::current()->parameter('id');

        $this->vehicleMaintenancesSubmissionCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                                            ->where('status', 'SUBMISSION')
                                                                            ->count();
        $this->vehicleMaintenancesPlanCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                                        ->where('status', 'PLAN')
                                                                        ->count();
        $this->vehicleMaintenancesMaintenanceCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                                                ->where('status', 'MAINTENANCE')
                                                                                ->count();
        $this->vehicleMaintenancesFinishedCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                                            ->where('status', 'FINISHED')
                                                                            ->count();

        $this->countTabs = [
            'vehicleMaintenancesSubmissionCount' => $this->vehicleMaintenancesSubmissionCount,
            'vehicleMaintenancesPlanCount' => $this->vehicleMaintenancesPlanCount,
            'vehicleMaintenancesMaintenanceCount' => $this->vehicleMaintenancesMaintenanceCount,
            'vehicleMaintenancesFinishedCount' => $this->vehicleMaintenancesFinishedCount,
        ];
    }

    function show($id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);
        $vehicleMaintenanceDetails = TmsVehicleMaintenanceDetail::where('tms_vehicle_maintenance_id', $vehicleMaintenance->id)->get();

        return view('tms.vehicle.detail.maintenance.show', [
            'vehicle' => $vehicle,
            'vehicleMaintenance' => $vehicleMaintenance,
            'vehicleMaintenanceDetails' => $vehicleMaintenanceDetails,
            ...$this->countTabs,
        ]);
    }

    function index(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleMaintenances = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                        ->where('status', $request->get('status'))
                                                        ->get();

        return view('tms.vehicle.detail.maintenance.index', [
            'vehicle' => $vehicle,
            'vehicleMaintenances' => $vehicleMaintenances,
            ...$this->countTabs,
        ]);
    }

    function create($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehiclePhysical = TmsVehiclePhysical::where('tms_vehicle_id', $id)->first();
        $vehicleDocument = TmsVehicleDocument::where('tms_vehicle_id', $id)->first();
        $assignments = TmsAssignment::with(['driver', 'details.customer'])->where('tms_vehicle_id', $id)->get();

        return view('tms.vehicle.detail.maintenance.create', [
            'vehicle' => $vehicle,
            'vehiclePhysical' => $vehiclePhysical,
            'vehicleDocument' => $vehicleDocument,
            'assignments' => $assignments,
            ...$this->countTabs,
        ]);
    }

    function storeRequest(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicleMaintenance = TmsVehicleMaintenance::create([
                'tms_vehicle_id' => $id,
                'name' => $request->name,
                'vendor' => $request->vendor,
                'planned_at' => $request->planned_at,
                'planned_kilometers' => $request->planned_kilometers,
                'planned_cost' => $request->planned_cost,
                'realized_at' => $request->realized_at,
                'realized_kilometers' => $request->realized_kilometers,
                'realized_cost' => $request->realized_cost,
                'status' => 'SUBMISSION',
                'context_type' => $request->context_type,
                'note' => $request->note,
            ]);

            $payload = collect([]);
            foreach ($request->detail_category as $key => $value) {
                $payload->push([
                    'tms_vehicle_maintenance_id' => $vehicleMaintenance->id,
                    'name' => $request->detail_name[$key] ?? '',
                    'part_number' => '', // TODO: gak jelas screenshotnya
                    'category' => $request->detail_category[$key],
                    'activity_type' => $request->detail_activity_type[$key],
                    // 'bin_location' => $request->detail_bin_location[$key] ?? '', // TODO: gak jelas screenshotnya
                    'planned_quantity' => $request->detail_planned_quantity[$key],
                    'planned_cost' => $request->detail_planned_cost[$key],
                    'planned_cost_total' => (int) $request->detail_planned_quantity[$key] * (int) $request->detail_planned_cost[$key],
                ]);
            }

            TmsVehicleMaintenanceDetail::insert($payload->toArray());

            DB::commit();

            return redirect()->route('tms.vehicle.show.maintenance.index', ['id' => $id, 'status' => 'submission'])->with('success', __('Vehicle maintenance successfully created.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function edit($id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);
        $vehicleMaintenanceDetails = TmsVehicleMaintenanceDetail::where('tms_vehicle_maintenance_id', $vehicleMaintenance->id)->get();

        return view('tms.vehicle.detail.maintenance.edit', [
            'vehicle' => $vehicle,
            'vehicleMaintenance' => $vehicleMaintenance,
            'vehicleMaintenanceDetails' => $vehicleMaintenanceDetails,
            ...$this->countTabs,
        ]);
    }

    function update(Request $request, $id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        // dd($request->all());

        try {
            DB::beginTransaction();

            $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);
            $vehicleMaintenance->fill($request->all());
            $vehicleMaintenance->save();

            $payload = collect([]);
            foreach ($request->detail_category as $key => $value) {
                $payload->push([
                    'tms_vehicle_maintenance_id' => $maintenanceId,
                    'name' => $request->detail_name[$key] ?? '',
                    'part_number' => '', // TODO: gak jelas screenshotnya
                    'category' => $request->detail_category[$key],
                    'activity_type' => $request->detail_activity_type[$key],
                    // 'bin_location' => $request->detail_bin_location[$key] ?? '', // TODO: gak jelas screenshotnya
                    'planned_quantity' => $request->detail_planned_quantity[$key],
                    'planned_cost' => $request->detail_planned_cost[$key],
                    'planned_cost_total' => (int) $request->detail_planned_quantity[$key] * (int) $request->detail_planned_cost[$key],
                ]);
            }

            $vehicleMaintenanceDetails = TmsVehicleMaintenanceDetail::where('tms_vehicle_maintenance_id', $maintenanceId);
            $vehicleMaintenanceDetails->delete();

            TmsVehicleMaintenanceDetail::insert($payload->toArray());

            DB::commit();

            return redirect()->route('tms.vehicle.show.maintenance.index', ['id' => $id, 'status' => 'submission'])->with('success', __('Vehicle maintenance successfully updated.'));
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with(['error' => 'Update data gagal!']);
        }
    }

    function editStatus($id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);

        return view('tms.vehicle.detail.maintenance.edit-status', [
            'vehicleMaintenance' => $vehicleMaintenance,
        ]);
    }

    function updateStatus(Request $request, $id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);
            $vehicleMaintenance->status = $request->status ?? 'SUBMISSION';
            $vehicleMaintenance->save();

            DB::commit();

            return redirect()->route('tms.vehicle.show.maintenance.index', ['id' => $id, 'status' => 'submission'])->with('success', __('Vehicle maintenance status successfully updated.'));
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with(['error' => 'Update data gagal!']);
        }
    }

    function editRealization($id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);
        $vehicleMaintenanceDetails = TmsVehicleMaintenanceDetail::where('tms_vehicle_maintenance_id', $vehicleMaintenance->id)->get();

        return view('tms.vehicle.detail.maintenance.realization', [
            'vehicle' => $vehicle,
            'vehicleMaintenance' => $vehicleMaintenance,
            'vehicleMaintenanceDetails' => $vehicleMaintenanceDetails,
            ...$this->countTabs,
        ]);
    }

    function updateRealization(Request $request, $id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        // dd($request->all());

        try {
            DB::beginTransaction();

            $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);
            $vehicleMaintenance->fill($request->all());
            $vehicleMaintenance->save();

            foreach ($request->detail_id as $key => $detailId) {
                $vehicleMaintenanceDetail = TmsVehicleMaintenanceDetail::find($detailId);
                $vehicleMaintenanceDetail->realized_quantity = $request->detail_realized_quantity[$key];
                $vehicleMaintenanceDetail->realized_cost = $request->detail_realized_cost[$key];
                $vehicleMaintenanceDetail->realized_cost_total = $request->detail_realized_quantity[$key] * $request->detail_realized_cost[$key];
                $vehicleMaintenanceDetail->save();
            }

            DB::commit();

            return redirect()->route('tms.vehicle.show.maintenance.index', ['id' => $id, 'status' => 'submission'])->with('success', __('Vehicle maintenance realization successfully added.'));
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with(['error' => 'Update data gagal!']);
        }
    }

    function destroy($id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);
            $vehicleMaintenanceDetail = TmsVehicleMaintenanceDetail::where('tms_vehicle_maintenance_id', $maintenanceId);
            $vehicleMaintenanceDetail->delete();
            $vehicleMaintenance->delete();

            DB::commit();

            return redirect()->route('tms.vehicle.show.maintenance.index', ['id' => $id, 'status' => 'submission'])->with('success', __('Vehicle maintenance successfully deleted.'));
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }
}
