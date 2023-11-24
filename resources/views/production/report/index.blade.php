@extends('layouts.admin')
@section('page-title')
    {{ __('Production Report') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Production Report'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('production.report.generate-xls') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Export Xls') }}">
            <i class="ti ti-file-export"></i>
        </a>
    </div>
@endsection

@section('content')
    @include('production.report._components.filter')

    <div id="printableArea" class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="tab-machine-all" role="tabpanel"
                            aria-labelledby="pills-user-tab-all">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Job Order') }}</th>
                                            <th>{{ __('Sales Order') }}</th>
                                            <th>{{ __('Customer') }}</th>
                                            <th>{{ __('Production Date') }}</th>
                                            <th>{{ __('Machine') }}</th>
                                            <th>{{ __('Unit') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('ID SJB') }}</th>
                                            <th>{{ __('Quantity') }}</th>
                                            <th>{{ __('Coil Number') }}</th>
                                            <th>{{ __('Spec') }}</th>
                                            <th>{{ __('Dimensions') }}</th>
                                            <th>T</th>
                                            <th>L</th>
                                            <th>P</th>
                                            <th>{{ __('Pcs Total') }}</th>
                                            <th>{{ __('Production Total') }} (kg mill)</th>
                                            <th>{{ __('Pack') }}</th>
                                            <th>{{ __('Description') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($scheduleDetails as $item)
                                            <tr>
                                                <td>{{ $item->job_order_number }}</td>
                                                <td>{{ $item->so_number }}</td>
                                                <td>{{ Auth::user()->customerNumberFormat($item->customer_id) ?? '<undefined>' }}</td>
                                                <td>{{ Auth::user()->dateFormat($item->production_date) }}</td>
                                                <td>{{ $item->machine_name }}</td>
                                                <td>{{ $item->product_service_unit_name }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>{{ $item->sku_number }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->no_coil }}</td>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ $item->dimensions }}</td>
                                                <td>{{ $item->dimension_t }}</td>
                                                <td>{{ $item->dimension_l }}</td>
                                                <td>{{ $item->dimension_p }}</td>
                                                <td>{{ $item->pieces }}</td>
                                                <td>{{ $item->production_total }}</td>
                                                <td>{{ $item->pack }}</td>
                                                <td>{{ $item->description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
