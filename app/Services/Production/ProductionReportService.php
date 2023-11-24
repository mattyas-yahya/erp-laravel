<?php

namespace App\Services\Production;

use Illuminate\Http\Request;
use App\Exports\ProductionScheduleExport;
use App\Repositories\Production\ProductionScheduleDbQueryRepository;
use Maatwebsite\Excel\Facades\Excel;

class ProductionReportService
{
    protected $productionScheduleDbRepo;

    public function __construct(
        ProductionScheduleDbQueryRepository $productionScheduleDbRepo,
    )
    {
        $this->productionScheduleDbRepo = $productionScheduleDbRepo;
    }

    public function getReport(Request $request)
    {
        $filters = [
            'year' => $request->get('year') ?? date('Y'),
            'month' => $request->get('month') ?? date('m'),
        ];

        $scheduleDetails = $this->productionScheduleDbRepo->reportPaginated($filters);

        return $scheduleDetails;
    }

    public function getReportXls(Request $request)
    {
        $filters = [
            'year' => $request->get('year') ?? date('Y'),
            'month' => $request->get('month') ?? date('m'),
        ];

        $name = 'production_' . date('Y-m-d h:i:s');
        $data = Excel::download((new ProductionScheduleExport($this->productionScheduleDbRepo))->setFilters($filters), $name . '.xlsx');
        ob_end_clean();

        return $data;
    }
}
