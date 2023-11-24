@extends('layouts.admin')

@section('page-title')
    {{ __('Monitoring Giro') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Monitoring Giro'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    {{-- <div class="float-end">
        <a href="{{ route('production.report.generate-xls') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Export Xls') }}">
            <i class="ti ti-file-export"></i>
        </a>
    </div> --}}
@endsection

@section('content')
    {{-- @include('report.marketing._components.filter') --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    @include('accounting.sales.giro-monitoring._components.content-table')
                </div>
            </div>
        </div>
    </div>
@endsection
