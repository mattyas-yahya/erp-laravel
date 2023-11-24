@extends('layouts.admin')
@section('page-title')
    {{ __('Kas Pembayaran') }}
@endsection

@section('breadcrumb')
    @include ('partials.admin.breadcrumbs', [
        'item' => __('Kas Pembayaran'),
    ])
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/datatable/buttons.dataTables.min.css') }}">
@endpush

@section('action-btn')
@endsection

@section('content')
    {{-- @include('production.schedule._components.filter') --}}

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5>*Kas Kecil Header</h5>
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('', 'Nomor', ['class' => 'form-label']) !!}
                            {!! Form::text('', $cashPayment->petty_cash_number, [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('', 'Tanggal', ['class' => 'form-label']) !!}
                            {!! Form::text('', \Auth::user()->dateFormat($cashPayment->date), [
                                'class' => 'form-control',
                                'readonly',
                            ]) !!}
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
                    <h5>*Detail Kas Pembayaran</h5>

                    <div class="col-auto float-end ms-2">
                        @unless ($cashPayment->status == \App\Domains\Accounting\PettyCash\PettyCashStatusValue::STATUS_DONE)
                        <a href="{{ route('accounting.petty-cash.petty-cash.detail.form', ['id' => $cashPayment->id]) }}" class="btn btn-sm btn-primary">
                            <i class="ti ti-plus"></i> Tambah Detail Kas Kecil
                        </a>
                        @endunless
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        @include('accounting.petty-cash.petty-cash.detail._components.content-table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
