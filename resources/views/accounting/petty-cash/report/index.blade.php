@extends('layouts.admin')
@section('page-title')
    {{ __('Laporan Kas Kecil') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Laporan Kas Kecil'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
@endsection

@section('content')
    {{-- @include('production.schedule._components.filter') --}}

    @foreach ($currentMonthWeeks as $weeks)
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>Periode {{ $weeks->start->format('d M Y') }} - {{ $weeks->end->format('d M Y') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        @include('accounting.petty-cash.report._components.content-table')
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
