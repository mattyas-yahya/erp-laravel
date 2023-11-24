<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TmsController extends Controller
{
    public function __construct() {}

    function index(Request $request)
    {
        // if (!Auth::user()->can('manage production')) {
        //     return redirect()->back()->with('error', __('Permission Denied.'));
        // }

        $schedules = $this->productionScheduleService->getSchedules($request);
        $machines = $this->productionMachineService->getMachines();

        return view('production.schedule.index', [
            'filterValues' => $filterValues,
            'schedules' => $schedules,
            'machines' => $machines,
        ]);
    }

    function show($id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $schedule = $this->productionScheduleService->findSchedule($id);
        $scheduleDetails = $this->productionScheduleService->getScheduleDetails($id);

        return view('production.schedule.show', [
            'schedule' => $schedule,
            'scheduleDetails' => $scheduleDetails,
        ]);
    }

    function create()
    {
        if (!Auth::user()->can('manage production')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $salesOrderDetails = $this->salesOrderService->getUnprocessedSalesOrderDetails();
        $machines = $this->productionMachineService->getMachines();
        $customers = $this->salesOrderService->getSalesOrderDetailCustomers($salesOrderDetails);
        $goodsDetails = $this->salesOrderService->getSalesOrderDetailGoodsDetail($salesOrderDetails);

        return view('production.schedule.create', [
            'salesOrderDetails' => $salesOrderDetails,
            'customers' => $customers,
            'goodsDetails' => $goodsDetails,
            'machines' => $machines,
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

        $salesOrderDetails = $this->salesOrderService->getUnprocessedSalesOrderDetails();
        $machines = $this->productionMachineService->getMachines();
        $productionStatusValues = $this->productionScheduleService->getProductionStatuses();
        $customers = $this->salesOrderService->getSalesOrderDetailCustomers($salesOrderDetails);

        return view('production.schedule.edit', [
            'schedule' => $schedule,
            'salesOrderDetails' => $salesOrderDetails,
            'customers' => $customers,
            'machines' => $machines,
            'productionStatusValues' => $productionStatusValues,
        ]);
    }

    function store(ProductionScheduleRequest $request)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $store = $this->productionScheduleService->createSchedule($request);

        if (!$store) {
            return redirect()->back()->with('error', __('Production schedule create failed.'));
        }

        return redirect()->back()->with('success', __('Production schedule successfully created.'));
    }

    function update(ProductionScheduleRequest $request, $id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $update = $this->productionScheduleService->updateSchedule($request, $id);

        if (!$update) {
            return redirect()->back()->with('error', __('Production schedule update failed.'));
        }

        return redirect()->back()->with('success', __('Production schedule successfully updated.'));
    }

    function destroy($id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $delete = $this->productionScheduleService->deleteSchedule($id);

        if (!$delete) {
            return redirect()->back()->with('error', __('Production schedule delete failed.'));
        }

        return redirect()->back()->with('success', __('Production schedule successfully deleted.'));
    }

    function finish($id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $update = $this->productionScheduleService->finishSchedule($id);

        if (!$update) {
            return redirect()->back()->with('error', 'Production schedule update failed.');
        }

        return redirect()->back()->with('success', 'Production schedule successfully updated.');
    }

    function generatePdf($id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $schedule = $this->productionScheduleService->findSchedule($id);

        if (empty($schedule)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $scheduleDetails = $this->productionScheduleService->getScheduleDetails($id);
        $scheduleDetailsLine = $scheduleDetails->where('type', 'line');
        $scheduleDetailsAval = $scheduleDetails->where('type', 'production_remaining');
        $sumProductionTotal = $this->productionScheduleService->sumProductionTotal($scheduleDetails);
        $sumPieces = $this->productionScheduleService->sumPieces(collect([
            ...$scheduleDetailsLine,
            ...$scheduleDetailsAval->where('production_total', '>', 0)
        ]));

        return view('production.schedule.pdf-template', [
            'schedule' => $schedule,
            'scheduleDetails' => $scheduleDetails,
            'sumProductionTotal' => $sumProductionTotal,
            'sumPieces' => $sumPieces,
        ]);
    }

    function generateMultiPdf(Request $request)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $schedules = $this->productionScheduleService->getSchedules($request);

        if (empty($schedules)) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $scheduleData = [];
        foreach ($schedules as $schedule) {
            $scheduleDetails = $this->productionScheduleService->getScheduleDetails($schedule->id);
            $scheduleDetailsLine = $scheduleDetails->where('type', 'line');
            $scheduleDetailsAval = $scheduleDetails->where('type', 'production_remaining');
            $sumProductionTotal = $this->productionScheduleService->sumProductionTotal($scheduleDetails);
            $sumPieces = $this->productionScheduleService->sumPieces(collect([
                ...$scheduleDetailsLine,
                ...$scheduleDetailsAval->where('production_total', '>', 0)
            ]));

            array_push($scheduleData, [
                'schedule' => $schedule,
                'scheduleDetails' => $scheduleDetails,
                'sumProductionTotal' => $sumProductionTotal,
                'sumPieces' => $sumPieces,
            ]);
        }

        return view('production.schedule.pdf-multiple-template', [
            'scheduleData' => $scheduleData,
        ]);
    }
}
