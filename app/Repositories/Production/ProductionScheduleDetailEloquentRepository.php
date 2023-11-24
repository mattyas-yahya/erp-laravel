<?php

namespace App\Repositories\Production;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Domains\Production\ProductionScheduleDetailTypeValue;
use App\Domains\Production\ProductionScheduleDetailPackValue;
use App\Models\ProductionScheduleDetail;

class ProductionScheduleDetailEloquentRepository
{
    public function getByProductionScheduleId($productionScheduleId)
    {
        return ProductionScheduleDetail::where('created_by', '=', Auth::user()->creatorId())
            ->where('production_schedule_id', $productionScheduleId)
            ->get();
    }

    public function find($id)
    {
        return ProductionScheduleDetail::find($id);
    }

    public function findProductionRemainingByProductionScheduleId($id)
    {
        return ProductionScheduleDetail::where('created_by', '=', Auth::user()->creatorId())
            ->where('production_schedule_id', $id)
            ->where('type', ProductionScheduleDetailTypeValue::TYPE_PRODUCTION_REMAINING)
            ->first();
    }

    public function create($request)
    {
        return ProductionScheduleDetail::create([
            'production_schedule_id' => $request->production_schedule_id,
            'dimension_t' => $request->dimension_t,
            'dimension_l' => $request->dimension_l,
            'dimension_p' => $request->dimension_p,
            'pieces' => $request->pieces,
            'pack' => $request->pack,
            'production_total' => $request->production_total,
            'description' => $request->description,
            'created_by' => Auth::user()->creatorId(),
        ]);
    }

    public function createProductionRemainingDetail($request)
    {
        return ProductionScheduleDetail::create([
            'production_schedule_id' => $request->production_schedule_id,
            'dimension_t' => $request->dimension_t,
            'dimension_l' => $request->dimension_l,
            'dimension_p' => $request->dimension_p,
            'pieces' => $request->pieces,
            'pack' => ProductionScheduleDetailPackValue::PACK_AVAL,
            'production_total' => 0,
            'description' => '',
            'type' => ProductionScheduleDetailTypeValue::TYPE_PRODUCTION_REMAINING,
            'created_by' => Auth::user()->creatorId(),
        ]);
    }

    public function update($request, $id)
    {
        $schedule = ProductionScheduleDetail::findOrFail($id);

        $schedule->fill($request->all());
        $schedule->save();

        return $schedule;
    }

    public function updateProductionRemainingDetail($request, $id)
    {
        $remaining = ProductionScheduleDetail::where('created_by', '=', Auth::user()->creatorId())
            ->where('production_schedule_id', $id)
            ->where('type', ProductionScheduleDetailTypeValue::TYPE_PRODUCTION_REMAINING)
            ->first();

        $remaining->fill($request->all());
        $remaining->save();

        return $remaining;
    }

    public function delete(string $id)
    {
        $deleted = 0;
        $detail = ProductionScheduleDetail::find($id);

        DB::transaction(function () use (&$deleted, $detail) {
            $deleted = $detail->delete();
        });

        return $deleted;
    }
}
