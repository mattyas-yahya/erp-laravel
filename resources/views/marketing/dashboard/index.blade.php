@extends('layouts.admin')

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>LAPORAN PENJUALAN MARKETING/CUSTOMER Periode Tahun 2023</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th rowspan="2">Marketing</th>
                                @foreach ($months as $month)
                                    <th rowspan="2">{{ $month }}</th>
                                @endforeach
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marketingEmployees as $marketingEmployee)
                                <tr>
                                    <td>{{ $marketingEmployee->name }}</td>
                                    @foreach ($months as $monthNumber => $month)
                                        <td>{{ $salesOrderDetails->whereIn(
                                                'so_id',
                                                $salesOrders->where('employee_id', $marketingEmployee->id)->filter(function ($value, $key) use ($monthNumber) {
                                                        return date('m-Y', $value->production_date) == $monthNumber . '-' . date('Y');
                                                    })->pluck('id'),
                                            )->sum('gr_from_so.weight') ?:
                                            '-' }}
                                        </td>
                                    @endforeach
                                    <td>{{ $salesOrderDetails->whereIn(
                                            'so_id',
                                            $salesOrders->where('employee_id', $marketingEmployee->id)->filter(function ($value, $key) use ($monthNumber) {
                                                    return date('Y', $value->production_date) == date('Y');
                                                })->pluck('id'),
                                        )->sum('gr_from_so.weight') ?:
                                        '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL</th>
                                @foreach ($months as $monthNumber => $month)
                                    <th>{{ $salesOrderDetails->whereIn(
                                            'so_id',
                                            $salesOrders->filter(function ($value, $key) use ($monthNumber) {
                                                    return date('m-Y', $value->production_date) == $monthNumber . '-' . date('Y');
                                                })->pluck('id'),
                                        )->sum('gr_from_so.weight') ?:
                                        '-' }}
                                    </th>
                                @endforeach
                                <th>{{ $salesOrderDetails->whereIn(
                                        'so_id',
                                        $salesOrders->filter(function ($value, $key) use ($monthNumber) {
                                                return date('Y', $value->production_date) == date('Y');
                                            })->pluck('id'),
                                    )->sum('gr_from_so.weight') ?:
                                    '-' }}
                                </th>
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
                <h5>Penjualan Marketing PT. Sampoerna Jaya Baja Surabaya Tahun 2023</h5>
            </div>
            <div class="card-body">
                <div class="scrollbar-inner">
                    <div id="line-chart" height="500"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    @include('marketing.dashboard._scripts.line-chart-script', [
        'series' => $marketingEmployees->map(function ($item) use ($months, $salesOrders, $salesOrderDetails) {
            return [
                'name' => $item->name,
                'data' => collect($months)->map(function ($month, $monthNumber) use ($item, $salesOrders, $salesOrderDetails) {
                    return $salesOrderDetails->whereIn(
                        'so_id',
                        $salesOrders->where('employee_id', $item->id)->filter(function ($value, $key) use ($item, $monthNumber, $salesOrders, $salesOrderDetails) {
                                return date('m-Y', $value->production_date) == $monthNumber . '-' . date('Y');
                            })->pluck('id'),
                    )->sum('gr_from_so.weight');
                })->flatten()
            ];
        })->toJson(),
    ])
@endpush
