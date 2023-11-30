<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Tms\Vehicle as TmsVehicle;
use App\Models\Tms\VehiclePhysical as TmsVehiclePhysical;
use App\Models\Tms\VehicleDocument as TmsVehicleDocument;
use App\Models\Tms\VehicleMaintenance as TmsVehicleMaintenance;
use App\Models\Tms\Assignment as TmsAssignment;

class VehicleDetailDashboardController extends Controller
{
    public function __construct()
    {
    }

    function index($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehiclePhysical = TmsVehiclePhysical::where('tms_vehicle_id', $id)->first();
        $vehicleDocument = TmsVehicleDocument::where('tms_vehicle_id', $id)->first();
        $assignments = TmsAssignment::with(['driver', 'details.customer'])
                                        ->where('tms_vehicle_id', $id)
                                        ->get();
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
}
