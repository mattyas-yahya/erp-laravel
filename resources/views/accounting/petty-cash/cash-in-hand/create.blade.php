@extends('layouts.admin')
@section('page-title')
    {{ __('Buat Uang Tunai') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Uang Tunai') }}</li>
@endsection

@section('content')
    {{ Form::open(['route' => 'accounting.petty-cash.cash-in-hand.store', 'class' => 'w-100']) }}
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('cash_in_hand_number', 'Nomor', ['class' => 'form-label']) !!}
                                {!! Form::text('cash_in_hand_number', null, ['class' => 'form-control', 'required', 'required']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('date', __('Date'), ['class' => 'form-label']) !!}
                                <div class="form-icon-user">
                                    {{ Form::date('date', null, ['class' => 'form-control', 'required' => 'required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('initial_balance', 'Saldo Awal', ['class' => 'form-label']) !!}
                                {!! Form::number('initial_balance', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('kasbon_balance', 'Saldo Kasbon', ['class' => 'form-label']) !!}
                                {!! Form::number('kasbon_balance', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('account_balance', 'Saldo Rekening', ['class' => 'form-label']) !!}
                                {!! Form::number('account_balance', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="form-group">
                                {!! Form::label('information', 'Keterangan', ['class' => 'form-label']) !!}
                                {!! Form::text('information', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0 form-table" id="sortable-table">
                        <thead>
                            <tr>
                                <th>Nilai Nominal</th>
                                <th>Jumlah Lembaran</th>
                                <th class="text-end">Total Nominal</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody class="ui-sortable">
                            @foreach ($nominals as $key => $nominal)
                                <tr>
                                    <td width="25%">
                                        <div class="form-group">
                                            {{ \Auth::user()->priceFormat($nominal) }}
                                        </div>
                                    </td>

                                    <td width="25%">
                                        <div class="form-group price-input">
                                            <input class="form-control cash-notes" data-nominal-value="{{ $nominal }}"
                                                required="required" placeholder="Jumlah Lembaran" name="{{ $key }}"
                                                type="number" min="0" value="0">
                                        </div>
                                    </td>
                                    <td class="text-end amount" data-amount-value="0">
                                        Rp 0
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th class="text-end"><strong>{{ __('Total') }}
                                        ({{ \Auth::user()->currencySymbol() }})</strong></th>
                                <th class="text-end total">Rp 0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}"
            onclick="location.href = '{{ route('accounting.petty-cash.cash-in-hand.index') }}';" class="btn btn-light">
        <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
    </div>
    {{ Form::close() }}
@endsection

@push('script-page')
    <script>
        $(document).on('keyup', '.cash-notes', function() {
            var el = $(this).parent().parent().parent();

            var cashNotes = $(this).val() ?? 0;
            var nominalValue = $(this).data('nominal-value');

            el.find('.amount').text('Rp ' + parseFloat(cashNotes * nominalValue).toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            el.find('.amount').data('amount-value', cashNotes * nominalValue);

            var amountValue = $('.form-table').find('.amount');
            var sumAmount = $.makeArray(amountValue.map(value => $(amountValue[value]).data('amount-value')))
                .reduce((accumulator, currentValue) => accumulator + currentValue, 0);

            $('.total').text('Rp ' +
                parseFloat(sumAmount.toFixed(2)).toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );
        })

        $(document).on('change', '.cash-notes', function() {
            var el = $(this).parent().parent().parent();

            var cashNotes = $(this).val() ?? 0;
            var nominalValue = $(this).data('nominal-value');

            el.find('.amount').text('Rp ' + parseFloat(cashNotes * nominalValue).toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            el.find('.amount').data('amount-value', cashNotes * nominalValue);

            var amountValue = $('.form-table').find('.amount');
            var sumAmount = $.makeArray(amountValue.map(value => $(amountValue[value]).data('amount-value')))
                .reduce((accumulator, currentValue) => accumulator + currentValue, 0);

            $('.total').text('Rp ' +
                parseFloat(sumAmount.toFixed(2)).toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
            );
        })
    </script>
@endpush
