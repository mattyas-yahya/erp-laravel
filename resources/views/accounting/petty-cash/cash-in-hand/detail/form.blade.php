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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {{ Form::open(['route' => ['accounting.petty-cash.petty-cash.detail.store', $cashPayment->id], 'method' => 'POST']) }}


            <div class="card">
                <div class="card-body table-border-style">
                    <h5>*Detail Kas Pembayaran</h5>

                    <div class="row">
                        <div class="float-end ms-2">
                            <div class="item-section py-4">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                                        <input type="button"value="{{__('Add new line')}}" class="add-form-row  btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-data">
                        @forelse ($cashPaymentDetails as $item)
                            @include('accounting.petty-cash.petty-cash.detail._components.form-row')
                        @empty
                            @include('accounting.petty-cash.petty-cash.detail._components.form-row-blank')
                        @endforelse
                    </div>
                </div>
            </div>

            <template class="template-form-row-blank">
                @include('accounting.petty-cash.petty-cash.detail._components.form-row-blank')
            </template>

            <div class="modal-footer">
                <a href="{{ route('accounting.petty-cash.petty-cash.detail.index', ['id' => $cashPayment->id]) }}" class="btn btn-light">{{ __('Cancel') }}</a>
                <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@push('script-page')
<script>
    $(document).on('click', '.add-form-row', function() {
        $('.form-data').append($('.template-form-row-blank').html());
    })

    $(document).on('click', '.delete-form-row', function() {
        $(this).closest('.form-row').remove();
    })
</script>
@endpush
