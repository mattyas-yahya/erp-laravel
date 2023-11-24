@extends('layouts.admin')
@section('page-title')
    {{ __('TMS Detail Riwayat Penugasan') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('TMS'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    <div class="float-end">
        {{-- @can('manage production') --}}
        <a href="#" title="{{ __('Create') }}" data-title="Tambah Detail Riwayat Penugasan"
            data-url="{{ route('tms.assignment.detail.create', $assignment->id) }}" data-size="lg" data-bs-toggle="tooltip" data-ajax-popup="true"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
        {{-- @endcan --}}
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5>*{{ __('TMS Detail Riwayat Penugasan') }} Header</h5>
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('', __('Delivery Order Number'), ['class' => 'form-label']) !!}
                            {!! Form::text('', $assignment->delivery_order_number, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('', __('Manifest Number'), ['class' => 'form-label']) !!}
                            {!! Form::text('', 'MANIFEST/' . Str::substr($assignment->delivery_order_number, -3), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('', __('Plat Nomor'), ['class' => 'form-label']) !!}
                            {!! Form::text('', $assignment->vehicle->license_plate, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('', __('Driver'), ['class' => 'form-label']) !!}
                            {!! Form::text('', $assignment->driver->name, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('', __('Tanggal Mulai'), ['class' => 'form-label']) !!}
                            {!! Form::text('', Auth::user()->dateFormat($assignment->started_at), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('', __('Komentar'), ['class' => 'form-label']) !!}
                            {!! Form::text('', $assignment->comment, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
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
                    @include('tms.assignment.detail._components.content-table')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
<script>
    var salesOrderDetailApiUrl = '{{ route('json.sales-order-detail') }}';

    $(document).on('change', '#sales_order_detail_id', function() {
        var salesOrderDetailId = $(this).val();

        console.log(salesOrderDetailId);

        if (!salesOrderDetailId) {
            return;
        }

        $.ajax({
            url: `${salesOrderDetailApiUrl}/${salesOrderDetailId}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': jQuery('#token').val()
            },
            cache: false,
            success: function(data) {
                setDetail(data);
            },
        });
    });

    function setDetail(data) {
        data.forEach(item => {
            $('#spec').val(item.gr_from_so.product_name)
            $('#qty').val(item.qty)
            $('#unit').val(item.unit)
        });
    }
</script>
@endpush

