@extends('layouts.admin')
@section('page-title')
    {{ __('Stock') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Stock'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('marketing.stock.generate-export-xls') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{ __('Export Xls') }}">
            <i class="ti ti-file-export"></i>
        </a>
    </div>
@endsection

@section('content')
    {{-- @include('marketing.report._components.filter') --}}

    <div id="printableArea" class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-user-tab-all">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('SPEC') }}</th>
                                            <th>{{ __('Dimensions') }}</th>
                                            <th>{{ __('Age') }}</th>
                                            <th>{{ __('ID SJB') }}</th>
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('No. Coil') }}</th>
                                            <th>{{ __('No Kontrak') }}</th>
                                            <th>{{ __('Mill') }}</th>
                                            <th>{{ __('Actual Thick') }}</th>
                                            <th>{{ __('Sum of Pcs') }}</th>
                                            <th>{{ __('Sum of Kg Mill') }}</th>
                                            <th>Keterangan Klaim</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gr as $item)
                                            <tr>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ $item->dimensions }}</td>
                                                <td class="text-end">
                                                    @isset($item?->gr?->date_goodscome)
                                                        {{ $item->goodsAge() }}
                                                    @endisset
                                                </td>
                                                <td>{{ $item->sku_number }}</td>
                                                <td>{{ $item->goods_location }}</td>
                                                <td>{{ $item->no_coil }}</td>
                                                <td>{{ $item->no_kontrak }}</td>
                                                <td>{{ $item->manufacture }}</td>
                                                <td class="text-end">{{ $item->actual_thick }}</td>
                                                <td class="text-end">{{ $item->qty }}</td>
                                                <td class="text-end">{{ $item->weight }}</td>
                                                <td>{{ $item->claim_note }}</td>
                                                <td>{{ $item->remarks }}</td>
                                                <td>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" title="{{ __('Edit Note') }}"
                                                            class="mx-3 btn btn-sm align-items-center"
                                                            data-title="{{ __('Edit Note') }}"
                                                            data-original-title="{{ __('Edit') }}"
                                                            data-url="{{ route('marketing.stock.edit', $item->id) }}"
                                                            data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip">
                                                            <i class="ti ti-pencil text-white"></i></a>
                                                    </div>
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
        </div>
    </div>
@endsection
