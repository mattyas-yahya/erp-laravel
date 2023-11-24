<?php

namespace App\Services\Production;

use Carbon\Carbon;
use App\Repositories\Production\ProductionMachineEloquentRepository;
use App\Repositories\Production\ProductionScheduleDbQueryRepository;

class ProductionDashboardService
{
    protected $machineRepo;
    protected $productionScheduleDbRepo;

    public function __construct(
        ProductionMachineEloquentRepository $machineRepo,
        ProductionScheduleDbQueryRepository $productionScheduleDbRepo,
    )
    {
        $this->machineRepo = $machineRepo;
        $this->productionScheduleDbRepo = $productionScheduleDbRepo;
    }

    public function machineProductivities()
    {
        // $machines = $this->machineRepo->all();
        $productionScheduleDetails = $this->productionScheduleDbRepo->reportAll([
            'year' => date('Y'),
        ]);
        // $productServices = $productionScheduleDetails
        //     ->map(function ($item) {
        //         return $item->product_name;
        //     })
        //     ->unique()
        //     ->values()
        //     ->all();

        // return collect((object) [
        //     'productionScheduleDetails' => $productionScheduleDetails,
        //     // 'machine_productivities' => $machineProductivities,
        //     // 'sub_total' => $subTotals,
        //     // 'monthly_productions' => $monthlyProductions,
        // ]);

        return $productionScheduleDetails;
    }
}
