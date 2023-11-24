@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Sales Order') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Sales Order') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="#" data-url="{{ route('sales-order.create') }}" data-size="lg" data-bs-toggle="tooltip"
            title="{{ __('Create') }}" data-ajax-popup="true" data-title="{{ __('Create New Sales Order') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">

                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                @include('sales_order._components.header-table')
                            </thead>
                            <tbody>
                                @include('sales_order._components.body-table')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
