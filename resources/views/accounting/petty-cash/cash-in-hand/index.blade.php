@extends('layouts.admin')

@section('page-title')
    {{ __('Uang Tunai') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Uang Tunai'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    <div class="float-end">
        {{-- @can('manage production') --}}
        <a href="{{ route('accounting.petty-cash.cash-in-hand.create') }}" data-title="{{ __('Tambah Uang Tunai') }}" data-bs-toggle="tooltip"
                title="{{ __('Create') }}" class="btn btn-sm btn-primary">
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
                    @include('accounting.petty-cash.cash-in-hand._components.content-table')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script></script>
@endpush
