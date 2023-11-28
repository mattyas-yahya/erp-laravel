<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Vender;
use App\Models\Tms\Vehicle as TmsVehicle;
use App\Models\Tms\VehiclePhysical as TmsVehiclePhysical;
use App\Models\Tms\VehicleDocument as TmsVehicleDocument;
use App\Models\Tms\Assignment as TmsAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Tms\VehicleRequest as TmsVehicleRequest;

class VehicleController extends Controller
{
    protected const VEHICLE_IMAGE_DIR_PATH = 'app/public/uploads/tms/vehicle';
    // protected const VEHICLE_STNK_DIR_PATH = 'app/public/uploads/tms/stnk';
    // protected const VEHICLE_BPKB_DIR_PATH = 'app/public/uploads/tms/bpkb';

    public function __construct()
    {
    }

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicles = TmsVehicle::with(['owner'])->get();

        return view('tms.vehicle.index', [
            'vehicles' => $vehicles,
        ]);
    }

    function create()
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $branches = Branch::all();
        $venders = Vender::all();

        return view('tms.vehicle.create', [
            'branches' => $branches,
            'venders' => $venders,
        ]);
    }

    function edit($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return response()->json(['error' => __('Permission denied.')], 401);
        // }

        $branches = Branch::all();
        $venders = Vender::all();
        $vehicle = TmsVehicle::findOrFail($id);
        $vehiclePhysical = TmsVehiclePhysical::where('tms_vehicle_id', $id)->first();
        $vehicleDocument = TmsVehicleDocument::where('tms_vehicle_id', $id)->first();

        return view('tms.vehicle.edit', [
            'branches' => $branches,
            'venders' => $venders,
            'vehicle' => $vehicle,
            'vehiclePhysical' => $vehiclePhysical,
            'vehicleDocument' => $vehicleDocument,
        ]);
    }

    function store(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $imagePath = $this->uploadImage($request->file('image'));

            $vehicle = TmsVehicle::create([
                'branch_id' => $request->branch_id,
                'type' => $request->type,
                'hull_number' => $request->hull_number,
                'license_plate' => $request->license_plate,
                'image' => $imagePath,
                'owner_id' => $request->owner_id,
                'active' => !empty($request->active),
                'inactive_reason' => $request->inactive_reason ?? '',
            ]);

            TmsVehiclePhysical::create([
                'tms_vehicle_id' => $vehicle->id,
                'model' => $request->model,
                'chassis_number' => $request->chassis_number,
                'engine_number' => $request->engine_number,
                'color' => $request->color,
                'imei_number' => $request->imei_number,
                'fuel_capacity' => $request->fuel_capacity,
                'fuel_usage_ratio' => $request->fuel_usage_ratio,
                'internal' => !empty($request->internal),
                'manufacturer_year' => $request->manufacturer_year,
                'start_operation_date' => $request->start_operation_date,
                'spare_tire_capacity' => $request->spare_tire_capacity,
                'kilometer_setting' => $request->kilometer_setting,
                'daily_travel_distance' => $request->daily_travel_distance,
                'gps_gsm_number' => $request->gps_gsm_number,
            ]);

            TmsVehicleDocument::create([
                'tms_vehicle_id' => $vehicle->id,
                'stnk_number' => $request->stnk_number,
                'stnk_owner_name' => $request->stnk_owner_name,
                'stnk_validity_period' => $request->stnk_validity_period,
                'stnk_owner_address' => $request->stnk_owner_address,
                'bpkb_number' => $request->bpkb_number,
                'last_kir_date' => $request->last_kir_date,
            ]);

            DB::commit();

            return redirect()->route('tms.vehicle.index')->with('success', __('Vehicle successfully created.'));
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

            $vehicle = TmsVehicle::findOrFail($id);
            $vehicle->fill($request->all());
            $vehicle->active = !empty($request->active);
            $vehicle->inactive_reason = $request->inactive_reason ?? '';

            if (!empty($request->file('image'))) {
                $imagePath = $this->uploadImage($request->file('image'));
                $vehicle->image = $imagePath;
            }

            $vehicle->save();

            $vehiclePhysical = TmsVehiclePhysical::where('tms_vehicle_id', $id)->first();
            $vehiclePhysical->fill($request->all());
            $vehiclePhysical->internal = !empty($request->internal);
            $vehiclePhysical->save();

            $vehicleDocument = TmsVehicleDocument::where('tms_vehicle_id', $id)->first();
            $vehicleDocument->fill($request->all());
            $vehicleDocument->save();

            DB::commit();

            return redirect()->route('tms.vehicle.index')->with('success', __('Vehicle successfully updated.'));
        } catch (\Throwable $e) {
            dd($e);
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

            $vehicle = TmsVehicle::find($id);
            $vehicle->physical()->delete();
            $vehicle->document()->delete();
            // $vehicle->maintenances()->details()->delete();
            $vehicle->maintenances()->delete();
            $vehicle->delete();

            DB::commit();

            return redirect()->route('tms.vehicle.index')->with('success', __('Vehicle successfully deleted.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }

    function activate($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicle = TmsVehicle::findOrFail($id);
            $vehicle->active = true;
            $vehicle->save();

            DB::commit();

            return redirect()->route('tms.vehicle.show', [
                'id' => $id
            ])->with('success', __('Vehicle successfully activated.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Update data gagal!');
        }
    }

    function deactivate($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicle = TmsVehicle::findOrFail($id);
            $vehicle->active = false;
            $vehicle->save();

            DB::commit();

            return redirect()->route('tms.vehicle.show', [
                'id' => $id
            ])->with('success', __('Vehicle successfully deactivated.'));
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Update data gagal!');
        }
    }

    private function uploadImage($file)
    {
        $filename = 'tms-vehicle-' . time() . '.' . $file->extension();

        $file->storeAs(self::VEHICLE_IMAGE_DIR_PATH, $filename);

        return $filename;
    }
}
