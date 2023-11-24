@extends('layouts.admin')
@section('page-title')
    Detail
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">TMS</li>
    <li class="breadcrumb-item"><a href="{{ route('tms.vehicle.index') }}">{{ __('Kendaraan') }}</a></li>
    <li class="breadcrumb-item">{{ $vehicle->license_plate }}</li>
    <li class="breadcrumb-item">Detail</li>
@endsection

@push('script-page')
@endpush

@section('content')
    <div class="p-3 card">
        <ul class="nav nav-tabs nav-fill" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-tab-dashboard" data-bs-toggle="pill"
                    data-bs-target="#tab-dashboard" type="button">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-tab-detail" data-bs-toggle="pill"
                    data-bs-target="#tab-detail" type="button">
                    <i class="fas fa-tags"></i> Detail
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-tab-maintenance" data-bs-toggle="pill"
                    data-bs-target="#tab-maintenance" type="button">
                    <i class="fas fa-wrench"></i> Perawatan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-tab-tire-management" data-bs-toggle="pill"
                    data-bs-target="#tab-tire-management" type="button">
                    <i class="fas fa-wrench"></i> Manajemen Ban
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-tab-tire-trailer" data-bs-toggle="pill"
                    data-bs-target="#tab-trailer" type="button">
                    <i class="fas fa-wrench"></i> Trailer
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="pills-tab-dashboard">
                @include('tms.vehicle._components.show-tab-dashboard')
            </div>

            <div class="tab-pane fade show" id="tab-maintenance" role="tabpanel" aria-labelledby="pills-tab-maintenance">
                @include('tms.vehicle._components.show-tab-maintenance')
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        $(document).ready(function () {
            const datatableMaintenanceRequest = new simpleDatatables.DataTable(".datatable-maintenance-request");
            const datatableMaintenancePlan = new simpleDatatables.DataTable(".datatable-maintenance-plan");
        });
    </script>
@endpush
