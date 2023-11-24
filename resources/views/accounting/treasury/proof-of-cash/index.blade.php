@extends('layouts.admin')
@section('page-title')
    {{ __('Bukti Kas') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Bukti Kas'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
@endsection

@section('content')
    {{-- @include('production.schedule._components.filter') --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    @include('accounting.treasury.proof-of-cash._components.content-table')
                </div>
            </div>
        </div>
    </div>
@endsection
