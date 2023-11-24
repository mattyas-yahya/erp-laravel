<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Domains\Production\ProductionScheduleDetailTypeValue;
use App\Http\Requests\ProductionScheduleDetailRequest;
// use App\Http\Requests\ProductionScheduleDetailEditRequest;
use App\Services\Production\ProductionScheduleService;

class ProductionScheduleDetailController extends Controller
{
    private $productionScheduleService;

    public function __construct(
        ProductionScheduleService $productionScheduleService
    ) {
        $this->productionScheduleService = $productionScheduleService;
    }

    function index($id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $schedule = $this->productionScheduleService->findSchedule($id);

        if (empty($schedule)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $scheduleDetails = $this->productionScheduleService->getScheduleDetails($id)
            ->where('type', ProductionScheduleDetailTypeValue::TYPE_LINE);
        $sumProductionTotal = $this->productionScheduleService->sumProductionTotal($scheduleDetails);
        $sumPieces = $this->productionScheduleService->sumPieces($scheduleDetails);
        $scheduleProductionFormula = $this->productionScheduleService->getFormula($schedule->status);

        return view('production.schedule.detail.index', [
            'schedule' => $schedule,
            'scheduleDetails' => $scheduleDetails,
            'sumProductionTotal' => $sumProductionTotal,
            'sumPieces' => $sumPieces,
            'scheduleProductionFormula' => $scheduleProductionFormula,
        ]);
    }

    function create($scheduleId)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $schedule = $this->productionScheduleService->findSchedule($scheduleId);

        if ($schedule->created_by !== Auth::user()->creatorId()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return view('production.schedule.detail.create', [
            'schedule' => $schedule,
        ]);
    }

    function store(ProductionScheduleDetailRequest $request)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $store = $this->productionScheduleService->createScheduleDetail($request);

        if (!$store) {
            return redirect()->back()->with('error', 'Production schedule detail create failed.');
        }

        return redirect()->back()->with('success', 'Production schedule detail successfully created.');
    }

    function edit($id, $detailId)
    {
        if (!Auth::user()->can('manage production')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $scheduleDetail = $this->productionScheduleService->findScheduleDetail($detailId);

        if ($scheduleDetail->created_by !== Auth::user()->creatorId()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $schedule = $this->productionScheduleService->findSchedule($id);

        return view('production.schedule.detail.edit', [
            'schedule' => $schedule,
            'scheduleDetail' => $scheduleDetail,
        ]);
    }

    function update(ProductionScheduleDetailRequest $request, $id, $detailId)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $update = $this->productionScheduleService->updateScheduleDetail($request, $detailId);

        if (!$update) {
            return redirect()->back()->with('error', 'Production schedule update failed.');
        }

        return redirect()->back()->with('success', 'Production schedule successfully updated.');
    }

    function destroy($id, $detailId)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $delete = $this->productionScheduleService->deleteScheduleDetail($detailId);

        if (!$delete) {
            return redirect()->back()->with('error', 'Production schedule detail delete failed.');
        }

        return redirect()->back()->with('success', 'Production schedule detail successfully deleted.');
    }
}
