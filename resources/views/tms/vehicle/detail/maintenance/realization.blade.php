@extends('layouts.admin')
@section('page-title')
    TMS Detail Perawatan Kendaraan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">TMS</li>
    <li class="breadcrumb-item"><a href="{{ route('tms.vehicle.index') }}">{{ __('Kendaraan') }}</a></li>
    <li class="breadcrumb-item">Detail</li>
    <li class="breadcrumb-item">Perawatan</li>
    <li class="breadcrumb-item">Tambah</li>
@endsection

@push('script-page')
@endpush

@section('content')
    <div class="p-3 card">
        @include('tms.vehicle.detail._components.tabs')

        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-maintenance" role="tabpanel" aria-labelledby="pills-tab-maintenance">
                <div class="row p-4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-lg-2 col-md-12">
                                <a href="{{ route('tms.vehicle.show.maintenance.create', ['id' => $vehicle->id]) }}" title="{{ __('Tambah Perawatan') }}" data-title="Tambah Perawatan" data-url="#"
                                    data-size="lg" data-bs-toggle="tooltip" class="btn btn-sm btn-primary">
                                    <i class="ti ti-plus"></i> Tambah Perawatan
                                </a>

                                <div class="card" style="top:30px">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ route('tms.vehicle.show.maintenance', ['id' => $vehicle->id, 'status' => 'request']) }}"
                                            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.maintenance' && Request::get('status') == 'request' ? ' active' : '' }}">Pengajuan
                                            <div class="float-end"><span class="badge bg-dark">0</span></div>
                                        </a>
                                        <a href="{{ route('tms.vehicle.show.maintenance', ['id' => $vehicle->id, 'status' => 'plan']) }}"
                                            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.maintenance' && Request::get('status') == 'plan' ? ' active' : '' }}">Rencana
                                            <div class="float-end"><span class="badge bg-dark">0</span></div>
                                        </a>
                                        <a href="{{ route('tms.vehicle.show.maintenance', ['id' => $vehicle->id, 'status' => 'maintenance']) }}"
                                            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.maintenance' && Request::get('status') == 'maintenance' ? ' active' : '' }}">Perawatan
                                            <div class="float-end"><span class="badge bg-dark">0</span></div>
                                        </a>
                                        <a href="{{ route('tms.vehicle.show.maintenance', ['id' => $vehicle->id, 'status' => 'finished']) }}"
                                            class="list-group-item list-group-item-action border-0 {{ Request::route()->getName() == 'tms.vehicle.show.maintenance' && Request::get('status') == 'finished' ? ' active' : '' }}">Selesai
                                            <div class="float-end"><span class="badge bg-dark">0</span></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-12 p-4">
                                {{ Form::open(['route' => ['tms.vehicle.show.maintenance.update', $vehicle->id, $vehicleMaintenance->id], 'method' => 'PUT']) }}
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {!! Form::label('name', __('Nama Perawatan'), ['class' => 'form-label']) !!}
                                            {!! Form::text('name', $vehicleMaintenance->name, ['class' => 'form-control', 'disabled']) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {!! Form::label('realized_kilometers', __('KM Selesai'), ['class' => 'form-label']) !!}
                                            {!! Form::number('realized_kilometers', null, ['class' => 'form-control', 'required', 'min' => 0]) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6">
                                            {{ Form::label('realized_at', 'Tanggal Selesai', ['class' => 'form-label']) }} <span
                                                class="text-danger">*</span>
                                            {{ Form::date('realized_at', null, ['class' => 'form-control', 'required']) }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {!! Form::label('realized_cost', __('Biaya Jasa'), ['class' => 'form-label']) !!}
                                            {!! Form::number('realized_cost', null, ['class' => 'form-control', 'required', 'min' => 0]) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {!! Form::label('vendor', __('Vendor'), ['class' => 'form-label']) !!}
                                            {!! Form::text('vendor', null, ['class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            {!! Form::label('note', __('Keterangan'), ['class' => 'form-label']) !!}
                                            {!! Form::text('note', null, ['class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>

                                    <br />
                                    <br />

                                    <h6>Detail</h6>
                                    <br />
                                    <br />

                                    <div class="row form-data">
                                    </div>

                                    <div class="row form-data">
                                        @foreach ($vehicleMaintenanceDetails as $item)
                                            @include('tms.vehicle.detail.maintenance._components.form-row-realization')
                                        @endforeach
                                    </div>

                                    <input type="submit" value="{{ __('Simpan') }}" class="btn btn-primary float-end" />
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template class="template-form-row-blank">
        @include('tms.vehicle.detail.maintenance._components.form-row-blank')
    </template>
@endsection
