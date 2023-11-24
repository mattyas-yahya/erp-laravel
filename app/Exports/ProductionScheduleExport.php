<?php

namespace App\Exports;

use App\Repositories\Production\ProductionScheduleDbQueryRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductionScheduleExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    public function __construct(ProductionScheduleDbQueryRepository $productionSchedules)
    {
        $this->productionSchedules = $productionSchedules;
    }

    public function setFilters(array $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    public function headings(): array
    {
        return [
            __('Job Order'),
            __('Sales Order'),
            __('Customer'),
            __('Production Date'),
            __('Machine'),
            __('Unit'),
            __('Status'),
            __('ID SJB'),
            __('Quantity'),
            __('Coil Number'),
            __('Spec'),
            __('Dimensions'),
            "T",
            "L",
            "P",
            __('Pcs Total'),
            __('Production Total') . " (kg mill)",
            __('Pack'),
            __('Description'),
        ];
    }

    public function collection()
    {
        return $this->productionSchedules->reportAll($this->filters);
    }

    public function map($productionScheduleDetails): array
    {
        return [
            $productionScheduleDetails->job_order_number,
            $productionScheduleDetails->so_number,
            \Auth::user()->customerNumberFormat($productionScheduleDetails->customer_id),
            $productionScheduleDetails->production_date,
            $productionScheduleDetails->machine_name,
            $productionScheduleDetails->product_service_unit_name,
            $productionScheduleDetails->status,
            $productionScheduleDetails->sku_number,
            $productionScheduleDetails->qty,
            $productionScheduleDetails->no_coil,
            $productionScheduleDetails->product_name,
            $productionScheduleDetails->dimensions,
            $productionScheduleDetails->dimension_t,
            $productionScheduleDetails->dimension_l,
            $productionScheduleDetails->dimension_p,
            $productionScheduleDetails->pieces,
            $productionScheduleDetails->production_total,
            $productionScheduleDetails->pack,
            $productionScheduleDetails->description,
        ];
    }
}
