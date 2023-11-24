<?php

namespace App\Repositories\Production;

use Illuminate\Support\Facades\Auth;
use App\Models\Machine;

class ProductionMachineEloquentRepository
{
    public function all()
    {
        $machines = Machine::where('created_by', Auth::user()->creatorId())
            ->get();

        return $machines;
    }

    public function find($id)
    {
        $machine = Machine::find($id);

        return $machine;
    }

    public function create($request)
    {
        return Machine::create([
            'name' => $request->name,
        ]);
    }

    public function update($request, $id)
    {
        $machine = Machine::findOrFail($id);

        $machine->fill($request->all());
        $machine->save();

        return $machine;
    }

    public function delete(string $id)
    {
        return Machine::destroy($id);
    }

    // public function machineProductions($year = null)
    // {
    //     if (empty($year)) {
    //         $year = date('Y');
    //     }

    //     $machineProductions = Machine::with([
    //         'productionSchedules' => function ($query) use ($year) {
    //             $query->whereYear('production_date', '=', $year);
    //         },
    //         'productionSchedules.salesOrderLine.gr_from_so.purchaseOrderDetail.productService',
    //         'productionSchedules.details',
    //     ])
    //         ->where('created_by', Auth::user()->creatorId())
    //         ->get();

    //     return $machineProductions;
    // }
}
