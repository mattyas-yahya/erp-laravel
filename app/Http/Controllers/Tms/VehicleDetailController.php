<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Tms\Vehicle as TmsVehicle;
use App\Models\Tms\VehiclePhysical as TmsVehiclePhysical;
use App\Models\Tms\VehicleDocument as TmsVehicleDocument;
use App\Models\Tms\VehicleMaintenance as TmsVehicleMaintenance;
use App\Models\Tms\VehicleMaintenanceDetail as TmsVehicleMaintenanceDetail;
use App\Models\Tms\VehicleFile as TmsVehicleFile;
use App\Models\Tms\Assignment as TmsAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleDetailController extends Controller
{
    protected const VEHICLE_DETAIL_FILE_DIR_PATH = 'app/public/uploads/tms/vehicle/files';

    public function __construct()
    {
    }

    // TODO: pisah ke controller beda
    function dashboard($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehiclePhysical = TmsVehiclePhysical::where('tms_vehicle_id', $id)->first();
        $vehicleDocument = TmsVehicleDocument::where('tms_vehicle_id', $id)->first();
        $assignments = TmsAssignment::with(['driver', 'details.customer'])->where('tms_vehicle_id', $id)->get();
        $vehicleMaintenances = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                        // ->where('status', 'FINISHED') // TODO: uncomment jika ganti status vehicle maintenance ke FINISHED selesai
                                                        ->latest()
                                                        ->first();

        return view('tms.vehicle.detail.dashboard.index', [
            'vehicle' => $vehicle,
            'vehiclePhysical' => $vehiclePhysical,
            'vehicleDocument' => $vehicleDocument,
            'assignments' => $assignments,
            'vehicleMaintenances' => $vehicleMaintenances,
        ]);
    }

    // TODO: pisah ke controller beda
    function vehicleFilesDetail($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleFiles = TmsVehicleFile::where('tms_vehicle_id', $id)->get();

        return view('tms.vehicle.detail.detail.files.index', [
            'vehicle' => $vehicle,
            'vehicleFiles' => $vehicleFiles,
        ]);
    }

    function createVehicleFilesDetail($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);

        return view('tms.vehicle.detail.detail.files.create', [
            'vehicle' => $vehicle,
        ]);
    }

    function storeVehicleFilesDetail(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $filePath = $this->uploadFile($request->file('file'));

            TmsVehicleFile::create([
                'tms_vehicle_id' => $id,
                'file' => $filePath,
                // 'file' => '',
                'name' => $request->name,
                'type' => $request->type,
                'expired_at' => $request->expired_at,
                'remaining_time' => $request->remaining_time,
                'active' => !empty($request->active),
            ]);

            DB::commit();

            return redirect()->route('tms.vehicle.show.detail.files.index', ['id' => $id])->with('success', __('Vehicle file successfully created.'));
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function updateVehicleFilesDetail(Request $request, $id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicleFile = TmsVehicleFile::findOrFail($maintenanceId);
            $vehicleFile->fill($request->all());
            $vehicleFile->file = $request->file;
            $vehicleFile->save();

            DB::commit();

            return redirect()->route('tms.vehicle.show.detail.files.index', ['id' => $id])->with('success', __('Vehicle file successfully created.'));
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    // TODO: pisah ke controller beda
    function maintenance(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleMaintenances = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                ->where('status', $request->get('status'))
                                ->get();

        $vehicleMaintenancesSubmissionCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                ->where('status', 'SUBMISSION')
                                                ->count();
        $vehicleMaintenancesPlanCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                        ->where('status', 'PLAN')
                                        ->count();
        $vehicleMaintenancesMaintenanceCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                ->where('status', 'MAINTENANCE')
                                                ->count();
        $vehicleMaintenancesFinishedCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                            ->where('status', 'FINISHED')
                                            ->count();

        return view('tms.vehicle.detail.maintenance.index', [
            'vehicle' => $vehicle,
            'vehicleMaintenances' => $vehicleMaintenances,
            'vehicleMaintenancesSubmissionCount' => $vehicleMaintenancesSubmissionCount,
            'vehicleMaintenancesPlanCount' => $vehicleMaintenancesPlanCount,
            'vehicleMaintenancesMaintenanceCount' => $vehicleMaintenancesMaintenanceCount,
            'vehicleMaintenancesFinishedCount' => $vehicleMaintenancesFinishedCount,
        ]);
    }

    function createMaintenance($id)
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
        ]);
    }

    function storeMaintenanceRequest(Request $request, $id)
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

    function editMaintenanceStatus($id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);

        return view('tms.vehicle.detail.maintenance.edit-status', [
            'vehicleMaintenance' => $vehicleMaintenance,
        ]);
    }

    function updateMaintenanceStatus(Request $request, $id, $maintenanceId)
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

    function editMaintenanceRealization($id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);
        $vehicleMaintenanceDetails = TmsVehicleMaintenanceDetail::where('tms_vehicle_maintenance_id', $vehicleMaintenance->id)->get();

        $vehicleMaintenancesSubmissionCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                ->where('status', 'SUBMISSION')
                                                ->count();
        $vehicleMaintenancesPlanCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                        ->where('status', 'PLAN')
                                        ->count();
        $vehicleMaintenancesMaintenanceCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                ->where('status', 'MAINTENANCE')
                                                ->count();
        $vehicleMaintenancesFinishedCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                            ->where('status', 'FINISHED')
                                            ->count();

        return view('tms.vehicle.detail.maintenance.realization', [
            'vehicle' => $vehicle,
            'vehicleMaintenance' => $vehicleMaintenance,
            'vehicleMaintenanceDetails' => $vehicleMaintenanceDetails,
            'vehicleMaintenancesSubmissionCount' => $vehicleMaintenancesSubmissionCount,
            'vehicleMaintenancesPlanCount' => $vehicleMaintenancesPlanCount,
            'vehicleMaintenancesMaintenanceCount' => $vehicleMaintenancesMaintenanceCount,
            'vehicleMaintenancesFinishedCount' => $vehicleMaintenancesFinishedCount,
        ]);
    }

    function updateMaintenance(Request $request, $id, $maintenanceId)
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

    function showMaintenance($id, $maintenanceId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleMaintenance = TmsVehicleMaintenance::findOrFail($maintenanceId);
        $vehicleMaintenanceDetails = TmsVehicleMaintenanceDetail::where('tms_vehicle_maintenance_id', $vehicleMaintenance->id)->get();

        $vehicleMaintenancesSubmissionCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                ->where('status', 'SUBMISSION')
                                                ->count();
        $vehicleMaintenancesPlanCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                        ->where('status', 'PLAN')
                                        ->count();
        $vehicleMaintenancesMaintenanceCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                                ->where('status', 'MAINTENANCE')
                                                ->count();
        $vehicleMaintenancesFinishedCount = TmsVehicleMaintenance::where('tms_vehicle_id', $id)
                                            ->where('status', 'FINISHED')
                                            ->count();

        return view('tms.vehicle.detail.maintenance.show', [
            'vehicle' => $vehicle,
            'vehicleMaintenance' => $vehicleMaintenance,
            'vehicleMaintenanceDetails' => $vehicleMaintenanceDetails,
            'vehicleMaintenancesSubmissionCount' => $vehicleMaintenancesSubmissionCount,
            'vehicleMaintenancesPlanCount' => $vehicleMaintenancesPlanCount,
            'vehicleMaintenancesMaintenanceCount' => $vehicleMaintenancesMaintenanceCount,
            'vehicleMaintenancesFinishedCount' => $vehicleMaintenancesFinishedCount,
        ]);
    }

    private function uploadFile($file)
    {
        $filename = 'tms-vehicle-file-' . time() . '.' . $file->extension();

        $file->storeAs(self::VEHICLE_DETAIL_FILE_DIR_PATH, $filename);

        return $filename;
    }
}
