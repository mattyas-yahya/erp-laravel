@extends('layouts.admin')
@section('page-title')
{{__('Manage Goods Receipt')}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{__('Goods Receipt')}}</li>
@endsection

@section('action-btn')
<div class="float-end">
    <a href="#" data-url="{{ route('goods-receipt.create') }}" data-size="lg" data-bs-toggle="tooltip"
        title="{{__('Create')}}" data-ajax-popup="true" data-title="{{__('Create New Goods Receipt')}}"
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
                                <th>{{__('GR Number')}}</th>
                                <th>{{__('PO Number')}}</th>
                                <th>{{__('No Kontrak')}}</th>
                                <th>{{__('No SP')}}</th>
                                <th>{{__('Supplier')}}</th>
                                <th>{{__('Arrival')}}</th>
                                <th>{{__('Owner')}}</th>
                                <th>{{__('Description')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($gr as $item)
                            <tr>
                                <td>{{ $item->gr_number }}</td>
                                <td>
                                    @if (!empty($item->po))
                                    <a href="#" data-url="{{ route('purchase-order.show',$item->po_id) }}"
                                        data-size="lg" data-bs-toggle="tooltip" title="{{__('Show')}}"
                                        data-ajax-popup="true" data-title="{{__('Show')}}"
                                        class="mx-3 btn btn-sm btn-outline-primary align-items-center">
                                        {{ $item->po->po_number }}
                                    </a>
                                    @endif
                                </td>
                                <td>{{ $item->no_kontrak }}</td>
                                <td>{{ $item->no_sp }}</td>
                                <td>{{ (!empty( $item->vender)?$item->vender->name:'') }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($item->date_goodscome)) }}</td>
                                <td>{{ (!empty( $item->cust)?$item->cust->name:'') }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->status }}</td>
                                @if(Gate::check('edit attendance') || Gate::check('delete attendance'))
                                <td>
                                    @if ($item->status == "Completed")
                                    <div class="action-btn bg-dark ms-2">
                                        <a href="{{ route('goods-receipt.print', $item->id) }}"
                                            class="btn btn-sm btn-icon m-1" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            title="{{ __('Print') }} - {{ $item->po->po_number }}" target="_blanks">
                                            <i class="ti ti-printer text-white"></i>
                                        </a>
                                    </div>
                                    @endif
                                    <div class="action-btn bg-warning ms-2">
                                        <a href="#" data-url="{{ route('goods-receipt.show',$item->id) }}"
                                            data-size="lg" data-bs-toggle="tooltip" title="{{__('Show')}}"
                                            data-ajax-popup="true" data-title="{{__('Show')}} - {{ $item->gr_number }}"
                                            class="mx-3 btn btn-sm align-items-center">
                                            <i class="ti ti-eye text-white"></i>
                                        </a>
                                    </div>
                                    <div class="action-btn bg-success ms-2">
                                        <a href="{{ route('goods-receipt.index_detail',$item->id) }}"
                                            data-title="{{__('Goods receipt line')}}"
                                            class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                            title="{{__('Goods receipt line')}}"
                                            data-original-title="{{__('Goods receipt line')}}">
                                            <i class="ti ti-plus text-white"></i></a>
                                    </div>
                                    <div class="action-btn bg-primary ms-2">
                                        <a href="#" data-url="{{ URL::to('goods-receipt/'.$item->id.'/edit') }}"
                                            data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Purchase')}}"
                                            class="mx-3 btn btn-sm align-items-center" data-bs-toggle="tooltip"
                                            title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                            <i class="ti ti-pencil text-white"></i></a>
                                    </div>
                                    @can('delete attendance')
                                    <div class="action-btn bg-danger ms-2">
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['goods-receipt.destroy',
                                        $item->id],'id'=>'delete-form-'.$item->id]) !!}

                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                            data-bs-toggle="tooltip" title="{{__('Delete')}}"
                                            data-original-title="{{__('Delete')}}"
                                            data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}"
                                            data-confirm-yes="document.getElementById('delete-form-{{$item->id}}').submit();">
                                            <i class="ti ti-trash text-white"></i></a>
                                        {!! Form::close() !!}
                                    </div>
                                    @endcan
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
@push('script-page')

@endpush