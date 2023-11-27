@extends('layouts.admin')
@section('page-title')
    {{ __('TMS Kendaraan') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('TMS'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    <div class="float-end">
        {{-- @can('manage production') --}}
        <a href="#" title="{{ __('Create') }}" data-title="Tambah Kendaraan" data-url="{{ route('tms.vehicle.create') }}"
            data-size="lg" data-bs-toggle="tooltip" data-ajax-popup="true" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        {{-- @endcan --}}
    </div>
@endsection

@section('content')
    {{-- @include('production.schedule._components.filter') --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    @include('tms.vehicle._components.content-table')
                </div>
            </div>
        </div>
    </div>
@endsection
