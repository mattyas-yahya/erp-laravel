@extends('layouts.admin')

@section('page-title')
    {{ __('Manage All Items Received') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('All Items Received') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('goods-itemreceived.generate-pdf') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
            title="{{ __('Export Pdf') }}">
            <i class="ti ti-file-export"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['goods-itemreceived.index'], 'method' => 'GET', 'id' => 'goods-itemreceived']) }}
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="col-xl-10">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('date', __('Date'), ['class' => 'form-label']) }}
                                            <input type="date" name="date" class="form-control"
                                                value="{{ old('date', $date ?? null) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                            {{ Form::label('product', __('SPEC'), ['class' => 'form-label']) }}
                                            <select class="form-control select" name="product" id="product" required>
                                                <option value=""> </option>
                                                @foreach ($allproduct as $item)
                                                    @if (old('product', $product) == $item->product_name)
                                                        <option value="{{ $item->product_name }}" selected>
                                                            {{ $item->product_name }}</option>
                                                    @else
                                                        <option value="{{ $item->product_name }}">
                                                            {{ $item->product_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary"
                                    onclick="document.getElementById('goods-itemreceived').submit(); return false;"
                                    data-bs-toggle="tooltip" title="{{ __('Search') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('goods-itemreceived.index') }}" class="btn btn-sm btn-danger"
                                    data-bs-toggle="tooltip" title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off "></i></span>
                                </a>
                            </div>

                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="col-auto float-end ms-2">
                        {!! Form::open([
                            'id' => 'print-qr-bulk-form',
                            'style' => 'display: none',
                            'method' => 'GET',
                            'route' => ['goods-itemreceived.qrcode'],
                            'target' => '_blank',
                        ]) !!}
                        <a href="javascript:;" onclick="document.getElementById('print-qr-bulk-form').submit();"
                            class="mx-3 btn btn-sm btn-icon m-1 btn-info align-items-center text-black"
                            data-bs-placement="top" title="{{ __('Print QR Code Selected') }}">
                            <i class="ti ti-qrcode text-black"></i> {{ __('Print QR Code Selected') }}
                        </a>
                        {!! Form::close() !!}
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>{{ __('Arrival') }}</th>
                                    <th>{{ __('PO Number') }}</th>
                                    <th>{{ __('No Kontrak') }}</th>
                                    <th>{{ __('ID_SJB') }}</th>
                                    <th>{{ __('No. Coil') }}</th>
                                    <th>{{ __('SPEC') }}</th>
                                    <th>{{ __('Dimensions') }}</th>
                                    <th>{{ __('Actual Thick') }}</th>
                                    <th>{{ __('Goods Location') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Weigth') }}(KG)</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Certificate') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gr as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input print-qr-bulk" name="id"
                                                value="{{ $item->id }}" />
                                            <div class="action-btn bg-info ms-2">
                                                <a href="{{ route('goods-itemreceived.qrcode', ['ids[]' => $item->id]) }}"
                                                    class="btn btn-sm btn-icon m-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ __('Print QR Code') }}"
                                                    target="_blanks">
                                                    <i class="ti ti-qrcode text-black"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            {{ isset($item->gr->date_goodscome) ? date('d-m-Y', strtotime($item->gr?->date_goodscome)) : '<GR not found>' }}
                                        </td>
                                        <td>{{ $item->po?->po_number ?? '<PO not found>' }}</td>
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
                                            @if ($item->upload_certificate)
                                                <a
                                                    href="{{ Storage::url('uploads/goods_receipt_certificate/' . $item->upload_certificate) }}">{{ __('See certificate') }}</a>
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
        $(document).ready(function() {
            // multi-select print
            const inputHidden = (val) =>
                `<input type="hidden" class="print-qr-bulk-form-id" name="ids[]" value="${val}">`;

            $('.print-qr-bulk').change(function() {
                const value = this.value;

                if (this.checked) {
                    $('#print-qr-bulk-form').append(inputHidden(value));
                }

                if (!this.checked) {
                    $(`.print-qr-bulk-form-id`).filter(function() {
                        return $(this).val() === value
                    }).remove();
                }

                const printBulkIdsCount = $(`.print-qr-bulk-form-id`).length;

                if (printBulkIdsCount > 0) {
                    $('#print-qr-bulk-form').show();
                } else {
                    $('#print-qr-bulk-form').hide();
                }

                $('#print-qr-bulk-form a').html(
                    `<i class="ti ti-qrcode text-black"></i> {{ __('Print QR Code Selected') }} (${printBulkIdsCount})`
                );
            });
        });
    </script>
@endpush
