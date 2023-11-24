@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Purchase Order') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Purchase order') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="#" data-url="{{ route('purchase-order.create') }}" data-size="lg" data-bs-toggle="tooltip"
            title="{{ __('Create') }}" data-ajax-popup="true" data-title="{{ __('Create New Purchase Order') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">

                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('PO Number') }}</th>
                                    <th>{{ __('Estimated Delivery Date') }}</th>
                                    <th>{{ __('No Kontrak') }}</th>
                                    <th>{{ __('Supplier') }}</th>
                                    <th>{{ __('Warehouse') }}</th>
                                    <th>{{ __('PR Number') }}</th>
                                    <th>{{ __('Created Date') }}</th>
                                    <th>{{ __('Payment Terms') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Note') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Approved') }}</th>
                                    <th>{{ __('Rejected') }}</th>
                                    <th>{{ __('Created By') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($po as $item)
                                    <tr>
                                        <td>{{ $item->po_number }}</td>
                                        <td>{{ \Auth::user()->dateFormat($item->send_date) }}</td>
                                        <td>{{ $item->no_kontrak }}</td>
                                        <td>{{ !empty($item->vender) ? $item->vender->name : '' }}</td>
                                        <td>{{ !empty($item->warehouse) ? $item->warehouse->name : '' }}</td>
                                        <td>
                                            @if (!empty($item->pr))
                                                <a href="#"
                                                    data-url="{{ route('purchase-request.show', $item->pr_id) }}"
                                                    data-size="lg" data-bs-toggle="tooltip" title="{{ __('Show') }}"
                                                    data-ajax-popup="true" data-title="{{ __('Show') }}"
                                                    class="mx-3 btn btn-sm btn-outline-primary align-items-center">
                                                    {{ $item->pr->pr_number }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ \Auth::user()->dateFormat($item->created_at) }}</td>
                                        <td>{{ !empty($item->terms) ? $item->terms->name : '' }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            {{ $item->getTotal->where('approval', '=', 'Approved')->count() }}
                                        </td>
                                        <td>
                                            {{ $item->getTotal->where('approval', '=', 'Rejected')->count() }}
                                        </td>
                                        <td>
                                            {{ $item->creator->name }}
                                        </td>
                                        @if (Gate::check('manage purchase order'))
                                            <td>
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#"
                                                        data-url="{{ route('purchase-order.show', $item->id) }}"
                                                        data-size="lg" data-bs-toggle="tooltip" title="{{ __('Show') }}"
                                                        data-ajax-popup="true"
                                                        data-title="{{ __('Show') }} - {{ $item->po_number }}"
                                                        class="mx-3 btn btn-sm align-items-center">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>

                                                <div class="action-btn bg-success ms-2">
                                                    <a href="{{ route('purchase-order.index_detail', $item->id) }}"
                                                        data-title="{{ __('Purchase order line') }}"
                                                        class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                        title="{{ __('Purchase order line') }}"
                                                        data-original-title="{{ __('Purchase order line') }}">
                                                        <i class="ti ti-plus text-white"></i></a>
                                                </div>
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#"
                                                        data-url="{{ URL::to('purchase-order/' . $item->id . '/edit') }}"
                                                        data-size="lg" data-ajax-popup="true"
                                                        data-title="{{ __('Edit Purchase') }}"
                                                        class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                                        title="{{ __('Edit') }}"
                                                        data-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i></a>
                                                </div>
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['purchase-order.destroy', $item->id],
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
                                            </td>
                                        @endif
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
