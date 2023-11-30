<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Tms\Vehicle as TmsVehicle;
use App\Models\Tms\VehicleFile as TmsVehicleFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VehicleDetailFileController extends Controller
{
    protected const VEHICLE_DETAIL_FILE_DIR_PATH = 'app/public/uploads/tms/vehicle/files';

    public function __construct()
    {
    }

    function index($id)
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

    function create($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);

        return view('tms.vehicle.detail.detail.files.create', [
            'vehicle' => $vehicle,
        ]);
    }

    function store(Request $request, $id)
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

    function edit($id, $fileId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleFile = TmsVehicleFile::findOrFail($fileId);

        return view('tms.vehicle.detail.detail.files.edit', [
            'vehicle' => $vehicle,
            'vehicleFile' => $vehicleFile,
        ]);
    }

    function update(Request $request, $id, $fileId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicleFile = TmsVehicleFile::findOrFail($fileId);
            $vehicleFile->fill($request->all());

            if (!empty($request->file('image'))) {
                $filePath = $this->uploadFile($request->file('file'));
                $vehicleFile->file = $filePath;
            }

            $vehicleFile->active = !empty($request->active);

            $vehicleFile->save();

            DB::commit();

            return redirect()->route('tms.vehicle.show.detail.files.index', ['id' => $id])->with('success', __('Vehicle file successfully updated.'));
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function destroy($id, $fileId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicleFile = TmsVehicleFile::findOrFail($fileId);

            if (!empty($vehicleFile->file)) {
                Storage::delete(self::VEHICLE_DETAIL_FILE_DIR_PATH . '/' . $vehicleFile->file);
            }

            $vehicleFile->delete();

            DB::commit();

            return redirect()->route('tms.vehicle.show.detail.files.index', ['id' => $id])->with('success', __('Vehicle file successfully deleted.'));
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }

    private function uploadFile($file)
    {
        $filename = 'tms-vehicle-file-' . time() . '.' . $file->extension();

        $file->storeAs(self::VEHICLE_DETAIL_FILE_DIR_PATH, $filename);

        return $filename;
    }
}
