@extends('layouts.admin')
@section('page-title')
{{__('Manage Payment Terms')}}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
<li class="breadcrumb-item">{{ __('Payment Terms') }}</li>
@endsection
@section('action-btn')
<div class="float-end">
    {{-- @can('create constant tax') --}}
    <a href="#" data-url="{{ route('payment-term.create') }}" data-ajax-popup="true" data-title="{{__('Create New Payment Terms')}}"
        data-bs-toggle="tooltip" title="{{__('Create')}}" class="btn btn-sm btn-primary">
        <i class="ti ti-plus"></i>
    </a>
    {{-- @endcan --}}
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-3">
        @include('layouts.procurement_setup')
    </div>
    <div class="col-9">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th> {{__('Name')}}</th>
                                <th> {{__('Hari')}}</th>
                                <th width="10%"> {{__('Action')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($terms as $item)
                            <tr class="font-style">
                                <td>{{ $item->name }}</td>
                                <td>{{ $item?->days }}</td>
                                <td class="Action">
                                    <span>
                                        {{-- @can('edit constant tax') --}}
                                        <div class="action-btn bg-primary ms-2">
                                            <a href="#" class="mx-3 btn btn-sm align-items-center"
                                                data-url="{{ route('payment-term.edit',$item->id) }}" data-ajax-popup="true"
                                                data-title="{{__('Edit Payment Terms')}}" data-bs-toggle="tooltip"
                                                title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                        {{-- @endcan
                                        @can('delete constant tax') --}}
                                        <div class="action-btn bg-danger ms-2">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['payment-term.destroy',
                                            $item->id],'id'=>'delete-form-'.$item->id]) !!}
                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                data-bs-toggle="tooltip" title="{{__('Delete')}}"
                                                data-original-title="{{__('Delete')}}"
                                                data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}"
                                                data-confirm-yes="document.getElementById('delete-form-{{$item->id}}').submit();">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                            {!! Form::close() !!}
                                        </div>
                                        {{-- @endcan --}}
                                    </span>
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
