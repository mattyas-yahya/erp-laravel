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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5>*Detail Jadwal Produksi</h5>
                    <div class="col-auto float-end ms-2">
                        <a href="#" data-url="{{ route('production.schedule.detail.create', $schedule->id) }}"
                            data-size="lg" data-bs-toggle="tooltip" title="{{ __('Add new line') }}" data-ajax-popup="true"
                            data-title="{{ __('Add new line') }} Detail Jadwal Produksi" class="btn btn-sm btn-primary">
                            <i class="ti ti-plus"></i> {{ __('Add new line') }}
                        </a>
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
                                    <th>Total Produksi (kg mill)</th>
                                    <th>Pack</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scheduleDetails as $item)
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
                                                        data-title="{{ __('Edit Production Schedule Detail') }}"
                                                        data-original-title="{{ __('Edit') }}"
                                                        data-url="{{ route('production.schedule.detail.edit', ['id' => $schedule->id, 'detailId' => $item->id]) }}" data-size="lg"
                                                        data-ajax-popup="true" data-bs-toggle="tooltip">
                                                        <i class="ti ti-pencil text-white"></i></a>
                                                </div>

                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['production.schedule.detail.destroy', ['id' => $schedule->id, 'detailId' => $item->id]],
                                                        'id' => 'delete-form-' . $item->id,
                                                    ]) !!}

                                                    <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                        title="{{ __('Delete') }}" data-bs-toggle="tooltip"
                                                        data-original-title="{{ __('Delete') }}"
                                                        data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                        <i class="ti ti-trash text-white"></i></a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table mb-0">
                            <tfoot>
                                <tr>
                                    <th data-sortable="" style="width: 13.713%;"></th>
                                    <th data-sortable="" style="width: 9.83455%;"></th>
                                    <th data-sortable="" style="width: 8.38015%;"></th>
                                    <th data-sortable="" style="width: 5.40208%;"></th>
                                    <th data-sortable="" style="width: 5.88688%;"></th>
                                    <th data-sortable="" style="width: 10.8734%;"></th>
                                    <th data-sortable="" style="width: 21.3313%;"></th>
                                    <th data-sortable="" style="width: 7.54906%;"></th>
                                    <th data-sortable="" style="width: 5.88688%;"><strong>{{ __('Production Result') }} Pcs</strong></th>
                                    <th data-sortable="" style="width: 11.1504%;">{{ $sumPieces }}</th>
                                </tr>
                                <tr>
                                    <th data-sortable="" style="width: 13.713%;"></th>
                                    <th data-sortable="" style="width: 9.83455%;"></th>
                                    <th data-sortable="" style="width: 8.38015%;"></th>
                                    <th data-sortable="" style="width: 5.40208%;"></th>
                                    <th data-sortable="" style="width: 5.88688%;"></th>
                                    <th data-sortable="" style="width: 10.8734%;"></th>
                                    <th data-sortable="" style="width: 21.3313%;"></th>
                                    <th data-sortable="" style="width: 7.54906%;"></th>
                                    <th data-sortable="" style="width: 5.88688%;"><strong>{{ __('Production Result') }} (Kg Mill)</strong></th>
                                    <th data-sortable="" style="width: 11.1504%;">{{ $sumProductionTotal }}</th>
                                </tr>
                                <tr>
                                    <th data-sortable="" style="width: 13.713%;"></th>
                                    <th data-sortable="" style="width: 9.83455%;"></th>
                                    <th data-sortable="" style="width: 8.38015%;"></th>
                                    <th data-sortable="" style="width: 5.40208%;"></th>
                                    <th data-sortable="" style="width: 5.88688%;"></th>
                                    <th data-sortable="" style="width: 10.8734%;"></th>
                                    <th data-sortable="" style="width: 21.3313%;"></th>
                                    <th data-sortable="" style="width: 7.54906%;"></th>
                                    <th data-sortable="" style="width: 5.88688%;"><strong>{{ __('Production Remaining') }}</strong></th>
                                    <th data-sortable="" style="width: 11.1504%;">{{ $schedule->production_remaining }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        let productionRemaining = {{ $schedule->production_remaining }};

        if (productionRemaining < 0) {
            Swal.fire(
                'Sisa Produksi Minus',
                'Jadwal produksi ini mempunyai sisa produksi yang minus yaitu : {{ $schedule->production_remaining }}',
                'error'
            );
        }

        let productionScheduleDetail = {
            t: null,
            l: null,
            p: null,
            pieces: null,
            quantity: {{ $schedule->salesOrderLine?->qty ?? 0 }},
        }

        function productionTotalFormula(productionScheduleDetail) {
            const {
                t,
                l,
                p,
                pieces,
                quantity
            } = productionScheduleDetail;
            return Math.round({{ $scheduleProductionFormula }});
        }
    </script>
@endpush
