<?php

namespace App\Services\Production;

use Illuminate\Http\Request;
use App\Domains\Helpers\NumberCodeHelper;
use App\Domains\Production\ProductionScheduleStatusValue;
use App\Domains\Production\ProductionScheduleFormula;
use App\Domains\Production\ProductionStatusValue;
use App\Http\Requests\ProductionScheduleRequest;
use App\Http\Requests\ProductionScheduleDetailRequest;
use App\Http\Requests\ProductionScheduleRemainingRequest;
use App\Repositories\Production\ProductionScheduleEloquentRepository;
use App\Repositories\Production\ProductionScheduleDetailEloquentRepository;
use App\Repositories\Marketing\SalesOrderDetailEloquentRepository;

class ProductionScheduleService
{
    protected $productionScheduleRepo;
    protected $productionScheduleDetailRepo;
    protected $salesOrderDetailRepo;

    public function __construct(
        ProductionScheduleEloquentRepository $productionScheduleRepo,
        ProductionScheduleDetailEloquentRepository $productionScheduleDetailRepo,
        SalesOrderDetailEloquentRepository $salesOrderDetailRepo,
    )
    {
        $this->productionScheduleRepo = $productionScheduleRepo;
        $this->productionScheduleDetailRepo = $productionScheduleDetailRepo;
        $this->salesOrderDetailRepo = $salesOrderDetailRepo;
    }

    public function getSchedules(Request $request)
    {
        $filters = [
            'year' => $request->get('year') ?? date('Y'),
            'month' => $request->get('month') ?? date('m'),
            'ids' => $request->get('ids'),
        ];

        $schedules = $this->productionScheduleRepo->all($filters);
        $schedules = $schedules->map(function ($item) {
            $item->production_remaining = $this->calculateProductionRemaining($item);
            $item->job_order_number_numeric = NumberCodeHelper::extract($item->job_order_number)->clean();

            return $item;
        });

        return $schedules;
    }

    public function findSchedule($id)
    {
        $schedule = $this->productionScheduleRepo->find($id);

        if (!empty($schedule)) {
            $schedule->production_remaining = $this->calculateProductionRemaining($schedule);
            $schedule->job_order_number_numeric = NumberCodeHelper::extract($schedule->job_order_number)->clean();
        }

        return $schedule;
    }

    public function createSchedule(ProductionScheduleRequest $request)
    {
        $created = $this->productionScheduleRepo->create($request);

        if ($created) {
            $this->salesOrderDetailRepo->setProductionScheduled($created->sales_order_line_id);
        }

        return $created;
    }

    public function updateSchedule(ProductionScheduleRequest $request, $id)
    {
        $updated = $this->productionScheduleRepo->update($request, $id);

        if ($updated) {
            switch ($request->production_status) {
                case ProductionStatusValue::STATUS_SCHEDULED:
                    $this->salesOrderDetailRepo->setProductionScheduled($updated->sales_order_line_id);
                    break;
                case ProductionStatusValue::STATUS_PROCESSED:
                    $this->salesOrderDetailRepo->setProductionProcessed($updated->sales_order_line_id);
                    break;
                case ProductionStatusValue::STATUS_FINISHED:
                    $this->salesOrderDetailRepo->setProductionFinished($updated->sales_order_line_id);
                    break;
                case ProductionStatusValue::STATUS_CANCELED:
                    $this->salesOrderDetailRepo->setProductionCanceled($updated->sales_order_line_id);
                    break;
                default:
                    $this->salesOrderDetailRepo->setProductionScheduled($updated->sales_order_line_id);
                    break;
            }
        }

        return $updated;
    }

    public function deleteSchedule(string $id)
    {
        $production = $this->productionScheduleRepo->find($id);

        if ($production) {
            return $this->productionScheduleRepo->delete($id);
        }

        return 0;
    }

    public function finishSchedule($id)
    {
        return $this->productionScheduleRepo->setProductionFinished($id);
    }

    public function getScheduleDetails(string $productionScheduleId)
    {
        return $this->productionScheduleDetailRepo->getByProductionScheduleId($productionScheduleId);
    }

    public function findScheduleDetail($id)
    {
        return $this->productionScheduleDetailRepo->find($id);
    }

    public function createScheduleDetail(ProductionScheduleDetailRequest $request)
    {
        $details = $this->getScheduleDetails($request->production_schedule_id);

        if ($details->count() === 0) {
            $this->createProductionRemainingDetail($request);
        }

        $this->productionScheduleRepo->setProductionProcessed($request->production_schedule_id);
        return $this->productionScheduleDetailRepo->create($request);
    }

    public function updateScheduleDetail(ProductionScheduleDetailRequest $request, $id)
    {
        return $this->productionScheduleDetailRepo->update($request, $id);
    }

    public function deleteScheduleDetail(string $id)
    {
        $detail = $this->productionScheduleDetailRepo->find($id);

        if ($detail) {
            return $this->productionScheduleDetailRepo->delete($id);
        }

        return 0;
    }

    public function findProductionRemainingDetail($productionScheduleId)
    {
        return $this->productionScheduleDetailRepo->findProductionRemainingByProductionScheduleId($productionScheduleId);
    }

    public function createProductionRemainingDetail(ProductionScheduleDetailRequest $request)
    {
        return $this->productionScheduleDetailRepo->createProductionRemainingDetail($request);
    }

    public function updateProductionRemainingDetail(ProductionScheduleRemainingRequest $request, $id)
    {
        return $this->productionScheduleDetailRepo->updateProductionRemainingDetail($request, $id);
    }

    public function sumProductionTotal($collection)
    {
        return $collection->sum('production_total');
    }

    public function sumPieces($collection)
    {
        return $collection->sum('pieces');
    }

    public function getStatuses()
    {
        return [
            ProductionScheduleStatusValue::STATUS_SH,
            ProductionScheduleStatusValue::STATUS_SL,
            ProductionScheduleStatusValue::STATUS_SL_AND_SH,
            ProductionScheduleStatusValue::STATUS_PACKING
        ];
    }

    public function getFormula($status)
    {
        if ($status == ProductionScheduleStatusValue::STATUS_SH) {
            return ProductionScheduleFormula::FORMULA_PRODUCTION_SH;
        } elseif ($status == ProductionScheduleStatusValue::STATUS_SL) {
            return ProductionScheduleFormula::FORMULA_PRODUCTION_SL;
        }

        return ProductionScheduleFormula::FORMULA_PRODUCTION_SH;
    }

    public function getProductionStatuses()
    {
        return [
            ProductionStatusValue::STATUS_SCHEDULED,
            ProductionStatusValue::STATUS_PROCESSED,
            ProductionStatusValue::STATUS_FINISHED,
            ProductionStatusValue::STATUS_CANCELED
        ];
    }

    private function calculateProductionRemaining($schedule)
    {
        return round($schedule->salesOrderLine?->gr_from_so?->weight - $schedule->details_sum_production_total, 2, PHP_ROUND_HALF_DOWN);
    }
}
