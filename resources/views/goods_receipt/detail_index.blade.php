@extends('layouts.admin')
@section('page-title')
    {{ __('Detail Goods Receipt') }} - {{ $gr->gr_number }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('goods-receipt.index') }}">{{ __('Goods receipt') }}</a></li>
    <li class="breadcrumb-item">{{ __('Detail Goods Receipt') }}</li>
@endsection

@push('script-page')
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5>*{{ __('Goods receipt') }} Header</h5>
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('created_at', __('Created Date'), ['class' => 'form-label']) !!}
                            {!! Form::text('created_at', \Auth::user()->dateFormat($gr->created_at), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('gr_number', __('GR Number'), ['class' => 'form-label']) !!}
                            {!! Form::text('name', $gr->gr_number, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('no_kontrak', __('No Kontrak'), ['class' => 'form-label']) !!}
                            {!! Form::text('no_kontrak', $gr->no_kontrak, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('po_number', __('PO Number'), ['class' => 'form-label']) !!}
                            {!! Form::text('name', $gr->po->po_number, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('no_sp', __('No.SP'), ['class' => 'form-label']) !!}
                            {!! Form::text('no_sp', $gr->no_sp, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('vendor', __('Supplier'), ['class' => 'form-label']) !!}
                            {!! Form::text('vendor', $gr->vender->name, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('date_goodscome', __('Arrival'), ['class' => 'form-label']) !!}
                            {!! Form::datetime('date_goodscome', date('d-m-Y H:i', strtotime($gr->date_goodscome)), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('customers_id', __('Owner'), ['class' => 'form-label']) !!}
                            {!! Form::text('customers_id', $gr->cust->name, ['class' => 'form-control', 'readonly']) !!}
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
                    <h5>*{{ __('Detail Goods Receipt') }} Line</h5>
                    @if ($gr->status != 'Completed')
                        <div class="col-auto float-end ms-2">
                            {!! Form::open([
                                'id' => 'goods-receipt-complete-form',
                                'method' => 'POST',
                                'route' => ['goods-receipt.complete-header', $gr->id],
                            ]) !!}
                            <a href="#" class="mx-3 btn btn-sm btn-danger align-items-center bs-pass-para"
                                data-original-title="{{ __('Complete') }}"
                                data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                data-confirm-yes="document.getElementById('goods-receipt-complete-form').submit();">
                                {{ __('Complete') }}
                            </a>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-auto float-end ms-2">
                            {!! Form::open([
                                'id' => 'delete-bulk-form',
                                'style' => 'display: none',
                                'method' => 'DELETE',
                                'route' => ['goods-receipt.destroy_bulk_detail'],
                            ]) !!}
                            <a
                                href="#"
                                class="mx-3 btn btn-sm btn-warning align-items-center bs-pass-para"
                                data-original-title="{{ __('Delete') }}"
                                data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                data-confirm-yes="document.getElementById('delete-bulk-form').submit();">
                                {{ __('Delete Selected') }}
                            </a>
                            {!! Form::close() !!}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    @if ($gr->status != 'Completed')
                                    <th></th>
                                    @endif
                                    <th>{{ __('PO Number') }}</th>
                                    <th>{{ __('No Kontrak') }}</th>
                                    <th>{{ __('ID_SJB') }}</th>
                                    <th>{{ __('No. Coil') }}</th>
                                    <th>{{ __('SPEC') }}</th>
                                    <th>{{ __('Dimensions') }}</th>
                                    <th>{{ __('Actual Thick') }}</th>
                                    <th>{{ __('Goods Location') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Weight') }} (KG)</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Certificate') }}</th>
                                    <th>{{ __('Approval') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datadetail as $item)
                                    <tr>
                                        @if ($gr->status != 'Completed')
                                        <td><input type="checkbox" class="form-check-input delete-bulk" name="id"
                                                value="{{ $item->id }}" /></td>
                                        @endif
                                        <td>{{ $item?->po?->po_number ?? '<PO number is missing>' }}</td>
                                        <td>{{ $item->no_kontrak }}</td>
                                        <td>{{ $item->sku_number }}</td>
                                        <td>{{ $item->no_coil }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->dimensions }}</td>
                                        <td>{{ $item->actual_thick }}</td>
                                        <td>{{ $item->goods_location }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->weight }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            @if($item->upload_certificate)
                                                <a href="{{ Storage::url('uploads/goods_receipt_certificate/' . $item->upload_certificate) }}">{{ __('See certificate') }}</a>
                                            @endif
                                        </td>
                                        <td>{{ $item->approval }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @if ($item->status != 'Completed')
                                                <div class="action-btn bg-success ms-2">
                                                    {!! Form::open(['method' => 'PATCH', 'route' => ['goods-receipt.update_detail', $item->id]]) !!}
                                                    <input type="hidden" name="sku_number"
                                                        value="{{ $item->sku_number }}">
                                                    <input type="hidden" name="no_coil" value="{{ $item->no_coil }}">
                                                    <input type="hidden" name="actual_thick"
                                                        value="{{ $item->actual_thick }}">
                                                    <input type="hidden" name="goods_location"
                                                        value="{{ $item->goods_location }}">
                                                    <input type="hidden" name="price_include"
                                                        value="{{ $item->price_include }}">
                                                    <input type="hidden" name="qty"
                                                        value="{{ $item->qty }}">
                                                    <input type="hidden" value="Completed" name="status">
                                                    <button type="submit"
                                                        class="mx-2 btn btn-sm d-inline-flex align-items-center"
                                                        title="{{ __('Complete') }}"
                                                        data-original-title="{{ __('Complete') }}">
                                                        <i class="ti ti-check text-white"></i></button>
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#"
                                                        data-url="{{ URL::to('goods-receipt/detail/' . $item->id . '/edit') }}"
                                                        data-size="lg" data-ajax-popup="true"
                                                        data-title="{{ __('Edit') }} - {{ $item?->po?->po_number }} - {{ $item->sku_number }}"
                                                        class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                        title="{{ __('Edit') }}"
                                                        data-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i></a>
                                                </div>
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['goods-receipt.destroy_detail', $item->id],
                                                        'id' => 'delete-form-' . $item->id,
                                                    ]) !!}
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm  align-items-center bs-pass-para text-white"
                                                        data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                        data-original-title="{{ __('Delete') }}"
                                                        data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                        X</a>
                                                    {!! Form::close() !!}
                                                </div>
                                            @endif
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

@push('script-page')
    <script>
        const inputHidden = (val) => `<input type="hidden" class="delete-bulk-form-id" name="id[]" value="${val}">`;

        $(document).ready(function() {
            $('.delete-bulk').change(function() {
                const value = this.value;

                if (this.checked) {
                    $('#delete-bulk-form').append(inputHidden(value));
                }

                if (!this.checked) {
                    $(`.delete-bulk-form-id`).filter(function() {
                        return $(this).val() === value
                    }).remove();
                }

                const deleteBulkIdsCount = $(`.delete-bulk-form-id`).length;

                if (deleteBulkIdsCount > 0) {
                    $('#delete-bulk-form').show();
                } else {
                    $('#delete-bulk-form').hide();
                }

                $('#delete-bulk-form a').text(`{{ __('Delete Selected') }} (${deleteBulkIdsCount})`);
            });
        });
    </script>
@endpush
