@extends('layouts.admin')
@section('page-title')
    {{ __('Sales Order History') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Sales Order History'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    {{-- <div class="float-end">
        <a href="{{ route('production.report.generate-xls') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Export Xls') }}">
            <i class="ti ti-file-export"></i>
        </a>
    </div> --}}
@endsection

@section('content')
    @include('marketing.history._components.filter')

    <div id="printableArea" class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
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
                                @foreach ($salesOrderDetails as $item)
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
                                            Rp {{ number_format($item->total, 2, ',', '.') }}
                                        </td>
                                        <td>{{ $item->description }}</td>
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
