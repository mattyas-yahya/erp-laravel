@extends('layouts.admin')
@section('page-title')
    {{ __('Kas Kecil') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Kas Kecil'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    <div class="float-end">
        {{-- @can('manage production') --}}
        <a href="#" title="{{ __('Create') }}" data-title="Tambah Kas Kecil" data-url="{{ route('accounting.petty-cash.petty-cash.create') }}"
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
                    <div class="tab-content" id="pills-tabContent">
                        @include('accounting.petty-cash.petty-cash._components.content-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
