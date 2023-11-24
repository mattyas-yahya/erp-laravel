@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Approval Purchase Order') }}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Approval') }}</li>
@endsection
@section('action-btn')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class=" mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['purchase-approval.index'], 'method' => 'GET', 'id' => 'purchase-approval']) }}
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('approval', __('Approval'), ['class' => 'form-label']) }}
                                    <select class="form-control" name="approval" required>
                                        <option value=" ">{{ __('ALL') }}</option>
                                        <option value="Approved"
                                            @isset($dataapproval) {{ $dataapproval == 'Approved' ? 'selected' : '' }}@endisset>
                                            Approved</option>
                                        <option value="Rejected"
                                            @isset($dataapproval) {{ $dataapproval == 'Rejected' ? 'selected' : '' }}@endisset>
                                            Rejected</option>
                                        <option value="-"
                                            @isset($dataapproval) {{ $dataapproval == '-' ? 'selected' : '' }}@endisset>
                                            Unapproved (-)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary"
                                    onclick="document.getElementById('purchase-approval').submit(); return false;"
                                    data-bs-toggle="tooltip" title="{{ __('Search') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('purchase-approval.index') }}" class="btn btn-sm btn-danger"
                                    data-bs-toggle="tooltip" title="{{ __('Reset') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-trash-off "></i></span>
                                </a>

                                <a href="{{ route('purchase-approval.export') }}" data-bs-toggle="tooltip"
                                    title="{{ __('Export') }}" class="btn btn-sm btn-primary ms-3">
                                    <i class="ti ti-file-export"></i>
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
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('PO Number') }}</th>
                                    <th>{{ __('PR Number') }}</th>
                                    <th>{{ __('No. Kontrak') }}</th>

                                    <th>{{ __('Sku') }}</th>
                                    <th>{{ __('SPEC') }}</th>
                                    <th>{{ __('Dimensions') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Weight') }}(KG)</th>
                                    <th>{{ __('Unit') }}</th>
                                    <th>{{ __('Tax PPN') }}</th>
                                    <th>{{ __('Tax PPh') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Sub Total') }} <br>
                                        <small
                                            class="text-danger font-weight-bold">{{ __('before tax & discount') }}</small>
                                    </th>
                                    <th>{{ __('PPN') }}</th>
                                    <th>{{ __('PPh') }}</th>
                                    <th>{{ __('Price Include') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Approval') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approval_po as $item)
                                    <tr
                                        class="font-style {{ $item->approval == '-' ? 'bg-blue-100' : '' }} {{ $item->approval == 'Approved' ? 'bg-green-200' : '' }}{{ $item->approval == 'Rejected' ? 'bg-red-200' : '' }}">
                                        <td>
                                            <a href="{{ route('purchase-order.index_detail', $item->po_id) }}"
                                                class="mx-3 btn btn-sm btn-outline-primary align-items-center"
                                                data-bs-toggle="tooltip" title="{{ __('Purchase order line') }}"
                                                data-original-title="{{ __('Purchase order line') }}">
                                                {{ $item->po_number }}
                                            </a>
                                        </td>
                                        <td>{{ !empty($item->pr) ? $item->pr->pr_number : '' }}</td>
                                        <td>{{ $item->no_kontrak }}</td>
                                        <td>{{ $item->sku_number }}</td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->dimensions }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->weight }}</td>
                                        <td>{{ $item?->unit()?->name }}</td>
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
                                        <td>Rp {{ $item->discount ?? 0 }}</td>
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
                                                    Rp
                                                    {{ number_format(round(($item->price * $taxValues->tax_ppn->value) * $item->weight, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                                @elseif ($item->unit()->name === 'Pcs')
                                                    Rp
                                                    {{ number_format(round(($item->price * $taxValues->tax_ppn->value) * $item->qty, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->tax_pph)
                                                @if ($item->unit()->name === 'Kg')
                                                    Rp
                                                    {{ number_format(round(($item->price * $taxValues->tax_pph->value) * $item->weight, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                                @elseif ($item->unit()->name === 'Pcs')
                                                    Rp
                                                    {{ number_format(round(($item->price * $taxValues->tax_pph->value) * $item->qty, 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}
                                                @endif
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format(round($item->price + ($item->tax_ppn ?  ($item->price * $taxValues->tax_pph->value) : 0) + ($item->tax_pph ? ($item->price * $taxValues->tax_pph->value) : 0), 2, PHP_ROUND_HALF_DOWN), 2, ',', '.') }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->approval }}</td>
                                        <td class="Action">
                                            @if ($item->approval == '-')
                                                <div class="action-btn bg-success ms-2">
                                                    {!! Form::open(['method' => 'PATCH', 'route' => ['purchase-approval.update', $item->id]]) !!}
                                                    <input type="hidden" value="Approved" name="approval">
                                                    <button type="submit"
                                                        class="mx-2 btn btn-sm d-inline-flex align-items-center"
                                                        title="{{ __('Approval') }}"
                                                        data-original-title="{{ __('Approval') }}">
                                                        <i class="ti ti-check text-white"></i></button>
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'PATCH', 'route' => ['purchase-approval.update', $item->id]]) !!}
                                                    <input type="hidden" value="Rejected" name="approval">
                                                    <button type="submit"
                                                        class="mx-2 btn btn-sm d-inline-flex align-items-center text-white"
                                                        title="{{ __('Reject') }}"
                                                        data-original-title="{{ __('Reject') }}">
                                                        X</button>
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
