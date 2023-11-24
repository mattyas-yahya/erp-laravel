@extends('layouts.admin')
@section('page-title')
    {{ __('Detail Sales Order') }} - {{ $so->so_number }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sales-order.index') }}">{{ __('Sales Order') }}</a></li>
    <li class="breadcrumb-item">{{ __('Detail Sales Order') }}</li>
@endsection
@push('script-page')
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5>*{{ __('Sales Order') }} Header</h5>
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('created_at', __('Created Date'), ['class' => 'form-label']) !!}
                            {!! Form::text('created_at', \Auth::user()->dateFormat($so->created_at), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('so_number', __('SO Number'), ['class' => 'form-label']) !!}
                            {!! Form::text('so_number', $so->so_number, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('no_kontrak', __('Konsumen'), ['class' => 'form-label']) !!}
                            {!! Form::text('no_kontrak', !empty($so->cust) ? $so->cust->name : '', ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('po_number', __('Warehouse'), ['class' => 'form-label']) !!}
                            {!! Form::text('name', !empty($so->warehouse) ? $so->warehouse->name : '', [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('reff_po_cust', __('Reff PO Cust'), ['class' => 'form-label']) !!}
                            {!! Form::text('reff_po_cust', $so->reff_po_cust, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('date_order', __('Order Date'), ['class' => 'form-label']) !!}
                            {!! Form::date('date_order', $so->date_order, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('vendor', __('Employee'), ['class' => 'form-label']) !!}
                            {!! Form::text('vendor', !empty($so->employees) ? $so->employees->name : '', [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('customers_id', __('Terms'), ['class' => 'form-label']) !!}
                            {!! Form::text('customers_id', !empty($so->terms) ? $so->terms->name : '', [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('customers_id', __('Delivery'), ['class' => 'form-label']) !!}
                            {!! Form::text('customers_id', $so->delivery, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('customers_id', __('Category'), ['class' => 'form-label']) !!}
                            {!! Form::text('customers_id', !empty($so->category) ? $so->category->name : '', [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('customers_id', __('Status'), ['class' => 'form-label']) !!}
                            {!! Form::text('customers_id', $so->status, ['class' => 'form-control', 'readonly']) !!}
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
                    <h5>*{{ __('Detail Sales Order') }} Line</h5>
                    <div class="col-auto float-end ms-2">
                        <a href="#" data-url="{{ route('sales-order.create_detail', $so->id) }}" data-size="lg"
                            data-bs-toggle="tooltip" title="{{ __('Add new line') }}" data-ajax-popup="true"
                            data-title="{{ __('Add new line') }} {{ __('Detail Sales Order') }}"
                            class="btn btn-sm btn-primary">
                            <i class="ti ti-plus"></i> {{ __('Add new line') }}
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('SO Number') }}</th>
                                    <th>{{ __('ID_SJB') }}</th>
                                    <th>{{ __('No. Coil') }}</th>
                                    <th>{{ __('Spec') }}</th>
                                    <th>{{ __('Weight') }}</th>
                                    <th>{{ __('Dimensions') }}</th>
                                    <th>{{ __('Qty') }}</th>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Production') }}</th>
                                    <th>{{ __('Tax PPN') }}</th>
                                    <th>{{ __('Tax PPh') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Sale Price') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datadetail as $item)
                                    <tr>
                                        <td>{{ $item->so_number }}</td>
                                        <td>{{ $item->gr_from_so?->sku_number }}</td>
                                        <td>{{ $item->gr_from_so?->no_coil }}</td>
                                        <td>{{ $item->gr_from_so?->product_name }}</td>
                                        <td>{{ $item->gr_from_so?->weight }}</td>
                                        <td>{{ $item->gr_from_so?->dimensions }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->unit }}</td>
                                        <td>{{ $item->production }}</td>
                                        <td>
                                            @includeWhen($item->tax_ppn, '_components.badges.tax', [
                                                'taxName' => $taxValues->tax_ppn->name,
                                                'taxRate' => $taxValues->tax_ppn->rate,
                                            ])
                                        </td>
                                        <td>
                                            @includeWhen($item->tax_pph, '_components.badges.tax', [
                                                'taxName' => $taxValues->tax_pph->name,
                                                'taxRate' => $taxValues->tax_pph->rate,
                                            ])
                                        </td>
                                        <td>{{ \Auth::user()->priceFormat($item->discount) }}</td>
                                        <td>{{ \Auth::user()->priceFormat($item->sale_price) }}</td>
                                        <td>
                                            @if ($item->unit === 'Lembar')
                                                Rp
                                                {{ number_format($item->sale_price * $item->qty - $item->discount, 2, ',', '.') }}
                                            @else
                                                @if ($item?->gr_from_so?->unit()->name === 'Kg')
                                                    Rp
                                                    {{ number_format($item->sale_price * $item?->gr_from_so?->weight - $item->discount, 2, ',', '.') }}
                                                @elseif ($item?->gr_from_so?->unit()->name === 'Pcs')
                                                    Rp
                                                    {{ number_format($item->sale_price * $item->qty - $item->discount, 2, ',', '.') }}
                                                @else
                                                    Rp
                                                    {{ number_format($item->sale_price * $item->qty - $item->discount, 2, ',', '.') }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="#"
                                                    data-url="{{ URL::to('sales-order/detail/' . $item->id . '/edit') }}"
                                                    data-size="lg" data-ajax-popup="true"
                                                    data-title="{{ __('Edit') }} - {{ $item->so_number }}"
                                                    class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                    title="{{ __('Edit') }}" data-original-title="{{ __('Edit') }}">
                                                    <i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['sales-order.destroy_detail', $item->id],
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @php
                            $subTotal = 0;
                            $subDiscountTotal = 0;
                            $subTaxTotal = 0;
                            foreach ($datadetail as $item) {
                                if ($item?->gr_from_so?->unit()->name === 'Kg') {
                                    $subTotal += $item->sale_price * $item?->gr_from_so?->weight;
                                } elseif ($item?->gr_from_so?->unit()->name === 'Pcs') {
                                    $subTotal += $item->sale_price * $item->qty;
                                } else {
                                    $subTotal += $item->sale_price * $item->qty;
                                }

                                $subDiscountTotal += $item->discount;
                                $taxRateTotal = 0;

                                if (!empty($item->tax_ppn)) {
                                    if ($item?->gr_from_so?->unit()->name === 'Kg') {
                                        $subTaxTotal += $item->sale_price * $taxValues->tax_ppn->value * $item?->gr_from_so?->weight;
                                    } elseif ($item?->gr_from_so?->unit()->name === 'Pcs') {
                                        $subTaxTotal += $item->sale_price * $taxValues->tax_ppn->value * $item->qty;
                                    }
                                }

                                if (!empty($item->tax_pph)) {
                                    if ($item?->gr_from_so?->unit()->name === 'Kg') {
                                        $subTaxTotal += $item->sale_price * $taxValues->tax_pph->value * $item?->gr_from_so?->weight;
                                    } elseif ($item?->gr_from_so?->unit()->name === 'Pcs') {
                                        $subTaxTotal += $item->sale_price * $taxValues->tax_pph->value * $item->qty;
                                    }
                                }
                            }

                            $subTotal = round($subTotal - $subDiscountTotal, 2, PHP_ROUND_HALF_DOWN);
                            $subTaxTotal = round($subTaxTotal, 2, PHP_ROUND_HALF_DOWN);
                            $total = $subTotal + $subTaxTotal;
                            $total = round($total, 2, PHP_ROUND_HALF_DOWN);
                        @endphp
                        <table class="table mb-0">
                            <tfoot>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>{{ __('Sub Total') }} ({{ \Auth::user()->currencySymbol() }})</strong>
                                    </td>
                                    <td class="text-end">{{ \Auth::user()->priceFormat($subTotal) }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td><strong>{{ __('Tax') }} ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="text-end">{{ \Auth::user()->priceFormat($subTaxTotal) }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="blue-text"><strong>{{ __('Total Amount') }}
                                            ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="blue-text text-end">{{ \Auth::user()->priceFormat($total) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
