@extends('layouts.admin')
@section('page-title')
    {{ __('TMS Riwayat Penugasan') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('TMS'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
    <style>
        .scrollable {
            position: relative;
            overflow-x: auto;
            overflow-y: hidden;
            flex-wrap: nowrap;
            height: 70px;
        }

        .scrollable .nav-link {
            white-space: nowrap;
        }
    </style>
@endpush

@section('action-btn')
    <div class="float-end">
        {{-- @can('manage production') --}}
        <a href="#" title="{{ __('Create') }}" data-title="Tambah Riwayat Penugasan"
            data-url="{{ route('tms.assignment.create') }}" data-size="lg" data-bs-toggle="tooltip" data-ajax-popup="true"
            class="btn btn-sm btn-primary">
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
                    @include('tms.assignment._components.content-table')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script></script>
@endpush
