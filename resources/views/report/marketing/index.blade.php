@extends('layouts.admin')
@section('page-title')
    {{ __('Marketing Report') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Marketing Report'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('report.marketing.export_xls') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Export Xls') }}">
            <i class="ti ti-file-export"></i> Excel
        </a>
        <a href="{{ route('report.marketing.export_pdf') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Export PDF">
            <i class="ti ti-file-export"></i> PDF
        </a>
    </div>
@endsection

@section('content')
    @include('report.marketing._components.filter')

    <div id="printableArea" class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Marketing') }}</th>
                                    @foreach ($salesOrderDetails->pluck('gr_from_so.product_name')->unique()->sort()->values()->all() as $productName)
                                        <th>{{ $productName }}</th>
                                    @endforeach
                                    <th>{{ __('Grand Total') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salesOrders->pluck('customer_id')->unique()->sort()->values()->all() as $customerNumber)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $salesOrders->where('customer_id', $customerNumber)->first()->cust->name }}
                                        </td>
                                        <td>{{ $salesOrders->where('customer_id', $customerNumber)->first()?->employees->name }}
                                        </td>
                                        @foreach ($salesOrderDetails->pluck('gr_from_so.product_name')->unique()->sort()->values()->all() as $productName)
                                            <td>{{ $salesOrderDetails->whereIn('so_id', $salesOrders->where('customer_id', $customerNumber)->pluck('id'))->where('gr_from_so.product_name', $productName)->sum('gr_from_so.weight') }}
                                            </td>
                                        @endforeach
                                        <td>{{ $salesOrderDetails->whereIn('so_id', $salesOrders->where('customer_id', $customerNumber)->pluck('id'))->sum('gr_from_so.weight') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr>
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td></td>
                                    @foreach ($salesOrderDetails->pluck('gr_from_so.product_name')->unique()->sort()->values()->all() as $productName)
                                        <td>
                                            <strong>{{ $salesOrderDetails->where('gr_from_so.product_name', $productName)->reduce(function ($carry, $detail) {
                                                return $carry + (float) $detail?->gr_from_so?->weight ?? 0;
                                            }, 0.0) > 0
                                                ? number_format(
                                                    round(
                                                        $salesOrderDetails->where('gr_from_so.product_name', $productName)->reduce(function ($carry, $detail) {
                                                            return $carry + (float) $detail?->gr_from_so?->weight ?? 0;
                                                        }, 0.0),
                                                    ),
                                                    0,
                                                    ',',
                                                    '.',
                                                )
                                                : '-' }}</strong>
                                        </td>
                                    @endforeach
                                    <td>
                                        <strong>{{ $salesOrderDetails->reduce(function ($carry, $detail) {
                                            return $carry + (float) $detail?->gr_from_so?->weight ?? 0;
                                        }, 0.0) > 0
                                            ? number_format(
                                                round(
                                                    $salesOrderDetails->reduce(function ($carry, $detail) {
                                                        return $carry + (float) $detail?->gr_from_so?->weight ?? 0;
                                                    }, 0.0),
                                                ),
                                                0,
                                                ',',
                                                '.',
                                            )
                                            : '-' }}</strong>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
