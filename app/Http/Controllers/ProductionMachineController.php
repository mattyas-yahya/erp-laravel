<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductionMachineRequest;
use App\Services\Production\ProductionMachineService;

class ProductionMachineController extends Controller
{
    private $productionMachineService;

    public function __construct(
        ProductionMachineService $productionMachineService
    ) {
        $this->productionMachineService = $productionMachineService;
    }

    function index()
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $machines = $this->productionMachineService->getMachines();

        return view('production.machine.index', [
            'machines' => $machines,
        ]);
    }

    function show($id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $machine = $this->productionMachineService->findMachine($id);

        return view('production.machine.show', [
            'machine' => $machine,
        ]);
    }

    function create()
    {
        if (!Auth::user()->can('manage production')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return view('production.machine.create');
    }

    function edit($id)
    {
        if (!Auth::user()->can('manage production')) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        $machine = $this->productionMachineService->findMachine($id);

        if ($machine->created_by !== Auth::id()) {
            return response()->json(['error' => __('Permission denied.')], 401);
        }

        return view('production.machine.edit', [
            'machine' => $machine,
        ]);
    }

    function store(ProductionMachineRequest $request)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $store = $this->productionMachineService->createMachine($request);

        if (!$store) {
            return redirect()->back()->with('error', 'Machine create failed.');
        }

        return redirect()->back()->with('success', 'Machine successfully created.');
    }

    function update(ProductionMachineRequest $request, $id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $update = $this->productionMachineService->updateMachine($request, $id);

        if (!$update) {
            return redirect()->back()->with('error', 'Machine update failed.');
        }

        return redirect()->back()->with('success', 'Machine successfully updated.');
    }

    function destroy($id)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $delete = $this->productionMachineService->deleteMachine($id);

        if (!$delete) {
            return redirect()->back()->with('error', 'Machine delete failed.');
        }

        return redirect()->back()->with('success', 'Machine successfully deleted.');
    }
}
