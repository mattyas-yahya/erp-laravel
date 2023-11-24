@extends('layouts.admin')
@section('page-title')
    {{ __('Detail Purchase Order') }} - {{ $po->po_number }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('purchase-order.index') }}">{{ __('Purchase order') }}</a></li>
    <li class="breadcrumb-item">{{ __('Detail Purchase Order') }}</li>
@endsection
@push('script-page')
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5>*{{ __('Purchase order') }} Header</h5>
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('created_at', __('Created Date'), ['class' => 'form-label']) !!}
                            {!! Form::text('created_at', \Auth::user()->dateFormat($po->created_at), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('po_number', __('PO Number'), ['class' => 'form-label']) !!}
                            {!! Form::text('name', $po->po_number, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('no_kontrak', __('No. Kontrak'), ['class' => 'form-label']) !!}
                            {!! Form::text('no_kontrak', $po->no_kontrak, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('vendor', __('Vendor'), ['class' => 'form-label']) !!}
                            {!! Form::text('vendor', $po->vender->name, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('warehouse', __('Warehouse'), ['class' => 'form-label']) !!}
                            {!! Form::text('warehouse', $po->warehouse->name, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('pr_number', __('PR Number'), ['class' => 'form-label']) !!}
                            {!! Form::text('pr_number', !empty($po->pr) ? $po->pr->pr_number : '', ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('send_date', __('Estimated Delivery Date'), ['class' => 'form-label']) !!}
                            {!! Form::date('send_date', $po->send_date, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('payment_term_id', __('Payment Terms'), ['class' => 'form-label']) !!}
                            {!! Form::text('payment_term_id', $po->terms->name, ['class' => 'form-control', 'readonly']) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('status', __('Status'), ['class' => 'form-label']) !!}
                            <br>
                            <span class="purchase_status badge bg-secondary p-2 px-3 rounded">{{ $po->status }}</span>
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
                    <h5>*{{ __('Detail Purchase Order') }} {{ __('Product & Services') }}</h5>
                    @if ($po->status != 'Created')
                        @if (empty($po->pr))
                            <div class="col-auto float-end ms-2">
                                <a href="#" data-url="{{ route('purchase-order.create_detail', $po->id) }}"
                                    data-size="lg" data-bs-toggle="tooltip" title="{{ __('Add new line') }}"
                                    data-ajax-popup="true"
                                    data-title="{{ __('Add new line') }} {{ __('Detail Purchase Order') }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="ti ti-plus"></i> {{ __('Add new line') }}
                                </a>
                            </div>
                        @endif
                        <div class="col-auto float-end ms-2">
                            {{ Form::model($po, ['route' => ['purchase-order.update', $po->id], 'method' => 'PATCH']) }}
                            <input type="hidden" name="category_id" value="{{ $po->category_id }}">
                            <input type="hidden" name="vender_id" value="{{ $po->vender_id }}">
                            <input type="hidden" name="warehouse_id" value="{{ $po->warehouse_id }}">
                            <input type="hidden" name="send_date" value="{{ $po->send_date }}">
                            <input type="hidden" name="payment_term_id" value="{{ $po->payment_term_id }}">
                            <input type="hidden" name="no_kontrak" value="{{ $po->no_kontrak }}">
                            <input type="hidden" name="status" value="Created">
                            <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip">
                                {{ __('Post!') }}
                            </button>
                            {{ Form::close() }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('PO Number') }}</th>
                                    <th>{{ __('No. Kontrak') }}</th>
                                    <th>{{ __('SPEC') }}</th>
                                    <th>{{ __('Dimensions') }}</th>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Weight') }}(KG)</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Received Quantity') }}</th>
                                    <th>{{ __('Tax PPN') }}</th>
                                    <th>{{ __('Tax PPh') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Sub Total') }} <br>
                                        <small class="text-danger font-weight-bold">{{ __('before tax & discount') }}</small>
                                    </th>
                                    <th>{{ __('PPN') }}</th>
                                    <th>{{ __('PPh') }}</th>
                                    <th>{{ __('Price Include') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Approval') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datadetail as $item)
                                    <tr>
                                        <td>{{ $item->po_number }}</td>
                                        <td>{{ $item->no_kontrak }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->dimensions }}</td>
                                        <td>{{ $item->unit()->name }}</td>
                                        <td>{{ $item->weight }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item?->goodsReceiptDetail?->qty ?? 0 }}</td>
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
                                        <td>{{ $item->discount }}</td>
                                        <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                        <td>
                                            @if ($item->unit()->name === 'Kg')
                                            Rp {{ number_format($item->price * $item->weight, 2, ',', '.') }}
                                            @elseif ($item->unit()->name === 'Pcs')
                                            Rp {{ number_format($item->price * $item->qty, 2, ',', '.') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->tax_ppn)
                                                @if ($item->unit()->name === 'Kg')
                                                    Rp {{ number_format(round(($item->price * $taxValues->tax_ppn->value) * $item->weight, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.')  }}
                                                @elseif ($item->unit()->name === 'Pcs')
                                                    Rp {{ number_format(round(($item->price * $taxValues->tax_ppn->value) * $item->qty, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->tax_pph)
                                                @if ($item->unit()->name === 'Kg')
                                                    Rp {{ number_format(round(($item->price * $taxValues->tax_pph->value) * $item->weight, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                                @elseif ($item->unit()->name === 'Pcs')
                                                    Rp {{ number_format(round(($item->price * $taxValues->tax_pph->value) * $item->qty, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format(round($item->price + ($item->tax_ppn ? ($item->price * $taxValues->tax_ppn->value) : 0) + ($item->tax_pph ? ($item->price * $taxValues->tax_pph->value) : 0), 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->approval }}</td>
                                        <td>
                                            @if ($po->status != 'Created')
                                                <div class="action-btn bg-dark ms-2">
                                                    {!! Form::open(['method' => 'POST', 'route' => ['purchase-order.store_detail']]) !!}
                                                    <input type="hidden" value="{{ $item->id }}" name="copypaste">
                                                    <button type="submit"
                                                        class="mx-2 btn btn-sm d-inline-flex align-items-center text-white"
                                                        title="{{ __('Duplicate') }}"
                                                        data-original-title="{{ __('Duplicate') }}">
                                                        <i class="ti ti-copy text-white"></i></button>
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#"
                                                        data-url="{{ URL::to('purchase-order/detail/' . $item->id . '/edit') }}"
                                                        data-size="lg" data-ajax-popup="true"
                                                        data-title="{{ __('Edit Qty') }}"
                                                        class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                        title="{{ __('Edit Qty') }}"
                                                        data-original-title="{{ __('Edit Qty') }}">
                                                        <i class="ti ti-pencil text-white"></i></a>
                                                </div>
                                                @if (empty($po->pr))
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['purchase-order.destroy_detail', $item->id],
                                                            'id' => 'delete-form-' . $item->id,
                                                        ]) !!}

                                                        <a href="#"
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $item->id }}').submit();">
                                                            <i class="ti ti-trash text-white"></i></a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endif
                                            @else
                                                <p>-</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @php
                            $subTotal = 0;
                            $subTaxTotal = 0;

                            foreach ($datadetail as $item) {
                                if ($item->unit()->name === 'Kg') {
                                    $subTotal += $item->price * $item->weight;
                                } elseif ($item->unit()->name === 'Pcs') {
                                    $subTotal += $item->price * $item->qty;
                                }

                                $taxRateTotal = 0;

                                if (!empty($item->tax_ppn)) {
                                    if ($item->unit()->name === 'Kg') {
                                        $subTaxTotal += ($item->price * $taxValues->tax_ppn->value) * $item->weight;
                                    } elseif ($item->unit()->name === 'Pcs') {
                                        $subTaxTotal += ($item->price * $taxValues->tax_ppn->value) * $item->qty;
                                    }
                                }

                                if (!empty($item->tax_pph)) {
                                    if ($item->unit()->name === 'Kg') {
                                        $subTaxTotal += ($item->price * $taxValues->tax_pph->value) * $item->weight;
                                    } elseif ($item->unit()->name === 'Pcs') {
                                        $subTaxTotal += ($item->price * $taxValues->tax_pph->value) * $item->qty;
                                    }
                                }
                            }

                            $subTotal = round($subTotal, 2, PHP_ROUND_HALF_DOWN);
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
                                    <td><strong>{{ __('Sub Total') }} ({{ \Auth::user()->currencySymbol() }})</strong>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($subTotal, 2, ',', '.') }}</td>
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
                                    <td><strong>{{ __('Tax') }} ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="text-end">Rp {{ number_format($subTaxTotal, 2, ',', '.') }}</td>
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
                                    <td class="blue-text"><strong>{{ __('Total Amount') }}
                                            ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="blue-text text-end">Rp {{ number_format($total, 2, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <h5 class="text-danger">*{{ __('Approval') }} {{ __('Rejected') }}</h5>
                    <div class="table-responsive mt-3">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('PO Number') }}</th>
                                    <th>{{ __('No. Kontrak') }}</th>
                                    <th>{{ __('SPEC') }}</th>
                                    <th>{{ __('Dimensions') }}</th>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Weight') }}(KG)</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Received Quantity') }}</th>
                                    <th>{{ __('Tax PPN') }}</th>
                                    <th>{{ __('Tax PPh') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Sub Total') }} <br>
                                        <small class="text-danger font-weight-bold">{{ __('before tax & discount') }}</small>
                                    </th>
                                    <th>{{ __('PPN') }}</th>
                                    <th>{{ __('PPh') }}</th>
                                    <th>{{ __('Price Include') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Approval') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datadetail_reject as $item)
                                <tr>
                                    <td>{{ $item->po_number }}</td>
                                    <td>{{ $item->no_kontrak }}</td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->dimensions }}</td>
                                    <td>{{ $item->unit()->name }}</td>
                                    <td>{{ $item->weight }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item?->goodsReceiptDetail?->qty ?? 0 }}</td>
                                    <td>
                                        @if ($item->tax_ppn)
                                            <span
                                                class="badge bg-primary mt-1 mr-2">{{ $taxes->where('id', 1)->first()->name . ' (' . $taxes->where('id', 1)->first()->value . '%)' }}</span>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tax_pph)
                                            <span
                                                class="badge bg-primary mt-1 mr-2">{{ $taxes->where('id', 2)->first()->name . ' (' . $taxes->where('id', 2)->first()->value . '%)' }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->discount }}</td>
                                    <td>Rp {{ number_format($item->price, 2, ',', '.') }}</td>
                                    <td>
                                        @if ($item->unit()->name === 'Kg')
                                        Rp {{ number_format($item->price * $item->weight, 2, ',', '.') }}
                                        @elseif ($item->unit()->name === 'Pcs')
                                        Rp {{ number_format($item->price * $item->qty, 2, ',', '.') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tax_ppn)
                                            @if ($item->unit()->name === 'Kg')
                                                Rp {{ number_format(round(($item->price * $taxValues->tax_ppn->value) * $item->weight, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.')  }}
                                            @elseif ($item->unit()->name === 'Pcs')
                                                Rp {{ number_format(round(($item->price * $taxValues->tax_ppn->value) * $item->qty, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->tax_pph)
                                            @if ($item->unit()->name === 'Kg')
                                                Rp {{ number_format(round(($item->price * $taxValues->tax_pph->value) * $item->weight, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                            @elseif ($item->unit()->name === 'Pcs')
                                                Rp {{ number_format(round(($item->price * $taxValues->tax_pph->value) * $item->qty, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>Rp {{ number_format(round($item->price + ($item->tax_ppn ? ($item->price * 11 / 100) : 0) + ($item->tax_pph ? ($item->price * 0.3 / 100) : 0), 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->approval }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @php
                            $subTotal = 0;
                            $subTaxTotal = 0;
                            foreach ($datadetail_reject as $item) {
                                if ($item->unit()->name === 'Kg') {
                                    $subTotal += $item->price * $item->weight;
                                } elseif ($item->unit()->name === 'Pcs') {
                                    $subTotal += $item->price * $item->qty;
                                }

                                $taxRateTotal = 0;

                                if (!empty($item->tax_ppn)) {
                                    if ($item->unit()->name === 'Kg') {
                                        $subTaxTotal += ($item->price * $taxValues->tax_ppn->value) * $item->weight;
                                    } elseif ($item->unit()->name === 'Pcs') {
                                        $subTaxTotal += ($item->price * $taxValues->tax_ppn->value) * $item->qty;
                                    }
                                }

                                if (!empty($item->tax_pph)) {
                                    if ($item->unit()->name === 'Kg') {
                                        $subTaxTotal += ($item->price * $taxValues->tax_pph->value) * $item->weight;
                                    } elseif ($item->unit()->name === 'Pcs') {
                                        $subTaxTotal += ($item->price * $taxValues->tax_pph->value) * $item->qty;
                                    }
                                }
                            }

                            $subTotal = round($subTotal, 2, PHP_ROUND_HALF_DOWN);
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
                                    <td><strong>{{ __('Sub Total') }} ({{ \Auth::user()->currencySymbol() }})</strong>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($subTotal, 2, ',', '.') }}</td>
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
                                    <td><strong>{{ __('Tax') }} ({{ \Auth::user()->currencySymbol() }})</strong>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($subTaxTotal, 2, ',', '.') }}</td>
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
