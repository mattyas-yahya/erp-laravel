@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Payment Type') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Manage Payment Type') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="#" data-url="{{ route('accounting.config.payment-type.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create Payment Type') }}" data-bs-toggle="tooltip" title="{{ __('Create') }}"
            class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-3">
            @include('layouts.account_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th> {{ __('Name') }}</th>
                                    <th> {{ __('Chart of Account') }}</th>
                                    <th width="10%"> {{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentTypes as $paymentType)
                                    <tr class="font-style">
                                        <td>{{ $paymentType->name }}</td>
                                        <td>{{ $paymentType?->chartOfAccount?->name }}</td>
                                        <td class="Action">
                                            <span>
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm align-items-center"
                                                        data-url="{{ route('accounting.config.payment-type.edit', $paymentType->id) }}"
                                                        data-ajax-popup="true" data-title="{{ __('Edit Payment Type') }}"
                                                        data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                        data-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['accounting.config.payment-type.destroy', $paymentType->id],
                                                        'id' => 'delete-form-' . $paymentType->id,
                                                    ]) !!}
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title="{{ __('Delete') }}"
                                                        data-original-title="{{ __('Delete') }}"
                                                        data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="document.getElementById('delete-form-{{ $paymentType->id }}').submit();">
                                                        <i class="ti ti-trash text-white"></i>
                                                    </a>
                                                    {!! Form::close() !!}
                                                </div>
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
