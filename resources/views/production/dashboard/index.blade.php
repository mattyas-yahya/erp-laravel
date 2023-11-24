@extends('layouts.admin')

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Machine Productivity') }} {{ $year }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Mesin</th>
                                <th class="text-end" rowspan="2">Berat</th>
                                <th class="text-center" colspan="{{ $machineProductivities->map(function ($item) { return $item->product_name; })->unique()->values()->count() }}">
                                    Spec</th>
                            </tr>
                            <tr>
                                @foreach ($machineProductivities->map(function ($item) { return $item->product_name; })->unique()->sort()->values()->all() as $product)
                                    <th class="text-end">{{ $product }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($machineProductivities->map(function ($item) { return $item->machine_name; })->unique()->sort()->values()->all() as $machineName)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $machineName }}</td>
                                    <td class="text-end">
                                        {{ $machineProductivities->where('machine_name', $machineName)
                                            ->reduce(function ($carry, $detail) {
                                                return $carry + (int) $detail?->production_total;
                                            }) > 0
                                            ? number_format(
                                                $machineProductivities->where('machine_name', $machineName)
                                                    ->reduce(function ($carry, $detail) {
                                                        return $carry + (int) $detail?->production_total;
                                                    }), 2, ',', '.')
                                            : '-'
                                        }}
                                    </td>
                                    @foreach ($machineProductivities->map(function ($item) { return $item->product_name; })->unique()->values()->all() as $product)
                                    <td class="text-end">
                                        {{ $machineProductivities->where('machine_name', $machineName)
                                            ->where('product_name', $product)
                                            ->reduce(function ($carry, $detail) {
                                                return $carry + (int) $detail?->production_total;
                                            }) > 0
                                            ? number_format(
                                                $machineProductivities->where('machine_name', $machineName)
                                                    ->where('product_name', $product)
                                                    ->reduce(function ($carry, $detail) {
                                                        return $carry + (int) $detail?->production_total;
                                                    }), 2, ',', '.')
                                            : '-'
                                        }}
                                    </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Grand Total</th>
                                <th class="text-end">
                                    {{ $machineProductivities->reduce(function ($carry, $detail) {
                                            return $carry + (int) $detail?->production_total;
                                        }) > 0
                                        ? number_format(
                                            $machineProductivities->reduce(function ($carry, $detail) {
                                                return $carry + (int) $detail?->production_total;
                                            }), 2, ',', '.')
                                        : '-'
                                    }}
                                </th>
                                @foreach ($machineProductivities->map(function ($item) { return $item->product_name; })->unique()->values()->all() as $product)
                                <th class="text-end">
                                    {{ $machineProductivities->where('product_name', $product)
                                        ->reduce(function ($carry, $detail) {
                                            return $carry + (int) $detail?->production_total;
                                        }) > 0
                                        ? number_format(
                                            $machineProductivities->where('product_name', $product)
                                                ->reduce(function ($carry, $detail) {
                                                    return $carry + (int) $detail?->production_total;
                                                }), 2, ',', '.')
                                        : '-'
                                    }}
                                </th>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="scrollbar-inner">
                    <div id="pie-chart" height="500"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                TABEL PRODUKSI TAHUNAN
            </div>
            <div class="card-body">
                <div class="scrollbar-inner">
                    <div id="bar-chart" height="500"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    @include('production.dashboard._scripts.pie-chart-script', [
        'series' => $machineProductivities->groupBy('machine_name')->map(function ($item) {
                        return $item->reduce(function ($carry, $detail) {
                            return $carry + (int) $detail?->production_total;
                        });
                    })->flatten()
                    ->toJson(),
        'labels' => $machineProductivities->map(function ($item) { return $item->machine_name; })->unique()->sort()->values()->toJson(),
    ])
    @include('production.dashboard._scripts.bar-chart-script', [
        'series' => $monthlyProductions->toJson(),
    ])
@endpush
