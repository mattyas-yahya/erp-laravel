@extends('layouts.admin')

@section('page-title')
    Jadwal Produksi - {{ $schedule->job_order_number }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('production.schedule.index') }}">{{ __('Production Schedule') }}</a></li>
    <li class="breadcrumb-item">Detail Jadwal Produksi</li>
@endsection

@push('script-page')
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5>*{{ __('Production Schedule') }} Header</h5>
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('created_at', __('Created Date'), ['class' => 'form-label']) !!}
                            {!! Form::text('created_at', Auth::user()->dateFormat($schedule->created_at), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('sales_order_number', 'Sales Order', ['class' => 'form-label']) !!}
                            {!! Form::text('sales_order_number', $schedule->salesOrderLine?->so_number, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('production_date', __('Production Date'), ['class' => 'form-label']) !!}
                            {!! Form::text('production_date', Auth::user()->dateFormat($schedule->production_date), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('job_order_number', __('Job Order Number'), ['class' => 'form-label']) !!}
                            {!! Form::text('job_order_number', $schedule->job_order_number, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('customer', __('Customer'), ['class' => 'form-label']) !!}
                            {!! Form::text('customer', Auth::user()->customerNumberFormat($schedule->customer->customer_id), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('id_sjb', __('ID SJB'), ['class' => 'form-label']) !!}
                            {!! Form::text('id_sjb', $schedule->salesOrderLine?->gr_from_so?->sku_number, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('coil_number', __('No. Coil'), ['class' => 'form-label']) !!}
                            {!! Form::text('coil_number', $schedule->salesOrderLine?->gr_from_so?->no_coil, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('weight', __('Weight'), ['class' => 'form-label']) !!}
                            {!! Form::text('weight', $schedule->salesOrderLine?->gr_from_so?->weight, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('production_status', __('Production Status'), ['class' => 'form-label']) !!}
                            <br />
                            <span class="status_badge badge bg-primary p-2 px-3 rounded">{{ $schedule->production_status }}</span>
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('production_remaining', __('Production Remaining'), ['class' => 'form-label']) !!}
                            {!! Form::text('production_remaining', $schedule->production_remaining, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5>*Sisa Produksi</h5>
                    <div class="col-auto float-end ms-2">
                        @unless ($schedule->production_status == App\Domains\Production\ProductionStatusValue::STATUS_FINISHED)
                        {{ Form::open(['route' => ['production.schedule.finish', $schedule->id], 'method' => 'PUT']) }}
                        <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip">
                            {{__('Finish')}}
                        </button>
                        {{ Form::close() }}
                        @endunless
                    </div>

                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Job Order</th>
                                    <th>No. Coil</th>
                                    <th>Spec</th>
                                    <th>T</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>Total Pcs</th>
                                    <th>Sisa Produksi (kg mill)</th>
                                    <th>Pack</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scheduleDetails->where('type', App\Domains\Production\ProductionScheduleDetailTypeValue::TYPE_LINE) as $item)
                                    <tr>
                                        <td>{{ $schedule->job_order_number }}</td>
                                        <td>{{ $schedule->salesOrderLine?->gr_from_so?->no_coil }}</td>
                                        <td>{{ $schedule->salesOrderLine?->gr_from_so?->product_name }}</td>
                                        <td>{{ $item->dimension_t }}</td>
                                        <td>{{ $item->dimension_l }}</td>
                                        <td>{{ $item->dimension_p }}</td>
                                        <td>{{ $item->pieces }}</td>
                                        <td>{{ $item->production_total }}</td>
                                        <td>{{ $item->pack }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                @foreach ($scheduleDetails->where('type', App\Domains\Production\ProductionScheduleDetailTypeValue::TYPE_PRODUCTION_REMAINING) as $item)
                                    <tr>
                                        <td>{{ $schedule->job_order_number }}</td>
                                        <td>{{ $schedule->salesOrderLine?->gr_from_so?->no_coil }}</td>
                                        <td>{{ $schedule->salesOrderLine?->gr_from_so?->product_name }}</td>
                                        <td>{{ $item->dimension_t }}</td>
                                        <td>{{ $item->dimension_l }}</td>
                                        <td>{{ $item->dimension_p }}</td>
                                        <td>{{ $item->pieces }}</td>
                                        <td>{{ $item->production_total }}</td>
                                        <td>{{ $item->pack }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            @can('manage production')
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" title="{{ __('Edit') }}"
                                                        class="mx-3 btn btn-sm align-items-center"
                                                        data-title="{{ __('Edit Production Schedule Production Remaining') }}"
                                                        data-original-title="{{ __('Edit') }}"
                                                        data-url="{{ route('production.schedule.production-remaining.edit', ['id' => $schedule->id]) }}" data-size="lg"
                                                        data-ajax-popup="true" data-bs-toggle="tooltip">
                                                        <i class="ti ti-pencil text-white"></i></a>
                                                </div>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
