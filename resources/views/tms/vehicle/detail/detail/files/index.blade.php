@extends('layouts.admin')
@section('page-title')
    TMS Detail - Detail Kendaraan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">TMS</li>
    <li class="breadcrumb-item"><a href="{{ route('tms.vehicle.index') }}">{{ __('Kendaraan') }}</a></li>
    <li class="breadcrumb-item">Detail</li>
    <li class="breadcrumb-item">Detail</li>
@endsection

@push('script-page')
@endpush

@section('content')
    <div class="p-3 card">
        @include('tms.vehicle.detail._components.tabs')

        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-detail" role="tabpanel" aria-labelledby="pills-tab-detail">
                @include('tms.vehicle.detail.detail._components.tab-content-files')
            </div>
        </div>
    </div>
@endsection
