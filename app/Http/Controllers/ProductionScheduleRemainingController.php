<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductionScheduleRemainingRequest;
use App\Domains\Production\ProductionScheduleDetailTypeValue;
use App\Services\Production\ProductionScheduleService;

class ProductionScheduleRemainingController extends Controller
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

        $scheduleDetails = $this->productionScheduleService->getScheduleDetails($id);
        // $sumProductionTotal = $this->productionScheduleService->sumProductionTotal($scheduleDetails);
        // $sumPieces = $this->productionScheduleService->sumPieces($scheduleDetails);
        // $scheduleProductionFormula = $this->productionScheduleService->getFormula($schedule->status);

        return view('production.schedule.production-remaining.index', [
            'schedule' => $schedule,
            'scheduleDetails' => $scheduleDetails,
            // 'sumProductionTotal' => $sumProductionTotal,
            // 'sumPieces' => $sumPieces,
            // 'scheduleProductionFormula' => $scheduleProductionFormula,
        ]);
    }

    function edit($id)
    {
        if (!Auth::user()->can('manage production')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $schedule = $this->productionScheduleService->findSchedule($id);

        if ($schedule->created_by !== Auth::user()->creatorId()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $productionRemainingDetail = $this->productionScheduleService->findProductionRemainingDetail($id);

        return view('production.schedule.production-remaining.edit', [
            'schedule' => $schedule,
            'productionRemainingDetail' => $productionRemainingDetail,
        ]);
    }

    function update(ProductionScheduleRemainingRequest $request, $id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $update = $this->productionScheduleService->updateProductionRemainingDetail($request, $id);

        if (!$update) {
            return redirect()->back()->with('error', 'Production schedule production remaining update failed.');
        }

        return redirect()->back()->with('success', 'Production schedule production remaining successfully updated.');
    }
}
