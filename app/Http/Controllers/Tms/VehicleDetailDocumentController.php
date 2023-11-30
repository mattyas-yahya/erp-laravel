<?php

namespace App\Http\Controllers\Tms;

use App\Http\Controllers\Controller;
use App\Models\Tms\Vehicle as TmsVehicle;
use App\Models\Tms\VehicleOtherDocument as TmsVehicleOtherDocument;
use App\Models\Tms\VehicleOtherDocumentDetail as TmsVehicleOtherDocumentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class VehicleDetailDocumentController extends Controller
{
    private $countTabs = [
        'vehicleDocumentsSubmissionCount' => 0,
        'vehicleDocumentsPlanCount' => 0,
        'vehicleDocumentsDocumentCount' => 0,
        'vehicleDocumentsFinishedCount' => 0,
    ];
    private $vehicleDocumentsSubmissionCount;
    private $vehicleDocumentsPlanCount;
    private $vehicleDocumentsDocumentCount;
    private $vehicleDocumentsFinishedCount;

    public function __construct()
    {
        $id = Route::current()->parameter('id');

        $this->vehicleDocumentsSubmissionCount = TmsVehicleOtherDocument::where('tms_vehicle_id', $id)
                                                                            ->where('status', 'SUBMISSION')
                                                                            ->count();
        $this->vehicleDocumentsPlanCount = TmsVehicleOtherDocument::where('tms_vehicle_id', $id)
                                                                        ->where('status', 'PLAN')
                                                                        ->count();
        $this->vehicleDocumentsDocumentCount = TmsVehicleOtherDocument::where('tms_vehicle_id', $id)
                                                                                ->where('status', 'DOCUMENT')
                                                                                ->count();
        $this->vehicleDocumentsFinishedCount = TmsVehicleOtherDocument::where('tms_vehicle_id', $id)
                                                                            ->where('status', 'FINISHED')
                                                                            ->count();

        $this->countTabs = [
            'vehicleDocumentsSubmissionCount' => $this->vehicleDocumentsSubmissionCount,
            'vehicleDocumentsPlanCount' => $this->vehicleDocumentsPlanCount,
            'vehicleDocumentsDocumentCount' => $this->vehicleDocumentsDocumentCount,
            'vehicleDocumentsFinishedCount' => $this->vehicleDocumentsFinishedCount,
        ];
    }

    function index(Request $request, $id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleOtherDocuments = TmsVehicleOtherDocument::where('tms_vehicle_id', $id)
                                                        ->where('status', $request->get('status'))
                                                        ->get();

        return view('tms.vehicle.detail.document.index', [
            'vehicle' => $vehicle,
            'vehicleOtherDocuments' => $vehicleOtherDocuments,
            ...$this->countTabs,
        ]);
    }

    function show($id, $documentId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleOtherDocument = TmsVehicleOtherDocument::findOrFail($documentId);
        $vehicleOtherDocumentDetails = TmsVehicleOtherDocumentDetail::where('tms_vehicle_detail_document_id', $vehicleOtherDocument->id)->get();

        return view('tms.vehicle.detail.document.show', [
            'vehicle' => $vehicle,
            'vehicleOtherDocument' => $vehicleOtherDocument,
            'vehicleOtherDocumentDetails' => $vehicleOtherDocumentDetails,
            ...$this->countTabs,
        ]);
    }

    function create($id)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);

        return view('tms.vehicle.detail.document.create', [
            'vehicle' => $vehicle,
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

            $vehicleOtherDocument = TmsVehicleOtherDocument::create([
                'tms_vehicle_id' => $id,
                'name' => $request->name,
                'vendor' => $request->vendor,
                'planned_at' => $request->planned_at,
                'planned_cost' => $request->planned_cost,
                'context_type' => $request->context_type,
                'status' => 'SUBMISSION',
                'note' => $request->note,
            ]);

            $payload = collect([]);
            foreach ($request->detail_category as $key => $value) {
                $payload->push([
                    'tms_vehicle_detail_document_id' => $vehicleOtherDocument->id,
                    'name' => $request->detail_name[$key],
                    'category' => $request->detail_category[$key],
                    'activity_type' => $request->detail_activity_type[$key],
                    'quantity' => $request->detail_quantity[$key],
                    'price' => $request->detail_price[$key],
                ]);
            }

            TmsVehicleOtherDocumentDetail::insert($payload->toArray());

            DB::commit();

            return redirect()->route('tms.vehicle.show.document.index', ['id' => $id, 'status' => 'submission'])->with('success', __('Vehicle document successfully created.'));
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();

            return redirect()->back()->with('error', 'Tambah data gagal!');
        }
    }

    function edit($id, $documentId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicle = TmsVehicle::findOrFail($id);
        $vehicleOtherDocument = TmsVehicleOtherDocument::findOrFail($documentId);
        $vehicleOtherDocumentDetails = TmsVehicleOtherDocumentDetail::where('tms_vehicle_detail_document_id', $vehicleOtherDocument->id)->get();

        return view('tms.vehicle.detail.document.edit', [
            'vehicle' => $vehicle,
            'vehicleOtherDocument' => $vehicleOtherDocument,
            'vehicleOtherDocumentDetails' => $vehicleOtherDocumentDetails,
            ...$this->countTabs,
        ]);
    }

    function update(Request $request, $id, $documentId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        // dd($request->all());

        try {
            DB::beginTransaction();

            $vehicleOtherDocument = TmsVehicleOtherDocument::findOrFail($documentId);
            $vehicleOtherDocument->fill($request->all());
            $vehicleOtherDocument->save();

            $payload = collect([]);
            foreach ($request->detail_category as $key => $value) {
                $payload->push([
                    'tms_vehicle_detail_document_id' => $vehicleOtherDocument->id,
                    'name' => $request->detail_name[$key],
                    'category' => $request->detail_category[$key],
                    'activity_type' => $request->detail_activity_type[$key],
                    'quantity' => $request->detail_quantity[$key],
                    'price' => $request->detail_price[$key],
                ]);
            }

            $vehicleOtherDocumentDetail = TmsVehicleOtherDocumentDetail::where('tms_vehicle_detail_document_id', $documentId);
            $vehicleOtherDocumentDetail->delete();

            TmsVehicleOtherDocumentDetail::insert($payload->toArray());

            DB::commit();

            return redirect()->route('tms.vehicle.show.document.index', ['id' => $id, 'status' => 'submission'])->with('success', __('Vehicle document successfully updated.'));
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with(['error' => 'Update data gagal!']);
        }
    }

    function editStatus($id, $documentId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $vehicleOtherDocument = TmsVehicleOtherDocument::findOrFail($documentId);

        return view('tms.vehicle.detail.document.edit-status', [
            'vehicleOtherDocument' => $vehicleOtherDocument,
        ]);
    }

    function updateStatus(Request $request, $id, $documentId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicleMaintenance = TmsVehicleOtherDocument::findOrFail($documentId);
            $vehicleMaintenance->status = $request->status ?? 'SUBMISSION';
            $vehicleMaintenance->save();

            DB::commit();

            return redirect()->route('tms.vehicle.show.document.index', ['id' => $id, 'status' => 'submission'])->with('success', __('Vehicle document status successfully updated.'));
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with(['error' => 'Update data gagal!']);
        }
    }

    function destroy($id, $documentId)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        try {
            DB::beginTransaction();

            $vehicleOtherDocument = TmsVehicleOtherDocument::findOrFail($documentId);
            $vehicleOtherDocumentDetail = TmsVehicleOtherDocumentDetail::where('tms_vehicle_detail_document_id', $documentId);
            $vehicleOtherDocumentDetail->delete();
            $vehicleOtherDocument->delete();

            DB::commit();

            return redirect()->route('tms.vehicle.show.document.index', ['id' => $id, 'status' => 'submission'])->with('success', __('Vehicle file successfully deleted.'));
        } catch (\Throwable $e) {
            dd($e);
            return redirect()->back()->with(['error' => 'Delete data gagal!']);
        }
    }
}
