<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use App\Models\Utility;
use App\Services\Production\ProductionDashboardService;

class ProductionDashboardController extends Controller
{
    private $productionDashboardSvc;

    public function __construct(
        ProductionDashboardService $productionDashboardSvc,
    )
    {
        $this->productionDashboardSvc = $productionDashboardSvc;
    }

    public function index(): View
    {
        if (!Auth::check()) {
            if (!file_exists(storage_path() . '/installed')) {
                header('location:install');
                die();
            } else {
                $settings = Utility::settings();
                if ($settings['display_landing_page'] == 'on') {
                    $plans = Plan::get();

                    return view('layouts.landing', compact('plans'));
                } else {
                    return redirect('login');
                }
            }
        }

        if (!Auth::user()->can('manage production dashboard')) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

        // Filter year
        $machineProductivities = $this->productionDashboardSvc->machineProductivities();

        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $monthlyProductions = collect([]);

        foreach ($months as $month) {
            $monthlyProductions->push($machineProductivities->filter(function ($item) use ($month) {
                    return Carbon::parse($item->production_date)->month === $month;
                })->reduce(function ($carry, $details) {
                    return $carry + (int) $details->production_total;
                }, 0)
            );
        }

        return view('production.dashboard.index', [
            'machineProductivities' => $machineProductivities,
            'monthlyProductions' => $monthlyProductions,
            'year' => date('Y')
        ]);
    }
}
