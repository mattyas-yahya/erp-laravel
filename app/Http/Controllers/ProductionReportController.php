<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Domains\Helpers\DateHelper;
use App\Services\Production\ProductionReportService;

class ProductionReportController extends Controller
{
    private $productionReportService;

    public function __construct(
        ProductionReportService $productionReportService,
    ) {
        $this->productionReportService = $productionReportService;
    }

    function index(Request $request)
    {
        if (!Auth::user()->can('manage production')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        $filterValues = [
            'years' => DateHelper::yearsOption(),
            'months' => DateHelper::monthsOption(),
        ];

        $scheduleDetails = $this->productionReportService->getReport($request);

        return view('production.report.index', [
            'filterValues' => $filterValues,
            'scheduleDetails' => $scheduleDetails,
        ]);
    }

    public function generateXls(Request $request)
    {
        return $this->productionReportService->getReportXls($request);
    }
}
