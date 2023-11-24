@extends('layouts.admin')

@section('page-title')
    {{ __('Journal Entry Edit') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Double Entry') }}</li>
    <li class="breadcrumb-item">{{ __('Journal Entry') }}</li>
@endsection

@section('content')
    {{ Form::model($journalEntry, ['route' => ['journal-entry.update', $journalEntry->id], 'method' => 'PUT', 'class' => 'w-100']) }}
    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('journal_number', __('Journal Number'), ['class' => 'form-label']) }}
                                <div class="form-icon-user">
                                    <input type="text" class="form-control"
                                        value="{{ \Auth::user()->journalNumberFormat($journalEntry->journal_id) }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('date', __('Transaction Date'), ['class' => 'form-label']) }}
                                <div class="form-icon-user">
                                    {{ Form::date('date', null, ['class' => 'form-control', 'required' => 'required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="form-group">
                                {{ Form::label('reference', __('Reference'), ['class' => 'form-label']) }}
                                <div class="form-icon-user">
                                    {{ Form::text('reference', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <div class="form-group">
                                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                                {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '2']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="item-section py-4">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                                <div class="all-button-box">
                                    <input type="button" id="add-account" value="Tambah Akun" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table">
                        <table class="table mb-0" id="sortable-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Account') }}</th>
                                    <th>{{ __('Debit') }}</th>
                                    <th>{{ __('Credit') }} </th>
                                    <th>{{ __('Description') }}</th>
                                    <th class="text-end">{{ __('Amount') }} </th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody class="ui-sortable">
                                @foreach ($journalEntry->accounts as $key => $item)
                                <tr>
                                    <td width="25%">
                                        {{ Form::hidden('accounts[' . $loop->index . '][id]', $key, ['class' => 'form-control id']) }}
                                        <div class="form-group">
                                            <select class="form-control select2" name="accounts[{{ $loop->index }}][account]" id="choices-multiple{{ $loop->index }}" required>
                                                @foreach ($accounts as $accountId => $account)
                                                    <option value="{{ $accountId }}" @if ($accountId == $item->account) selected @endif>{{ $account }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group price-input">
                                            <input class="form-control debit" required="required" placeholder="Debit" name="accounts[{{ $loop->index }}][debit]" type="text" value="{{  $item->debit }}" {{ $item->credit > 0 && $item->debit == 0 ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group price-input">
                                            <input class="form-control credit" required="required" placeholder="Credit" name="accounts[{{ $loop->index }}][credit]" type="text" value="{{ $item->credit }}" {{ $item->credit == 0 && $item->debit > 0 ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            {{ Form::text('accounts[' . $loop->index . '][description]', $item->description, ['class' => 'form-control', 'placeholder' => __('Description')]) }}
                                        </div>
                                    </td>
                                    <td class="text-end amount">
                                        {{ $item->debit ?: $item->credit }}
                                    </td>
                                    <td>
                                        <a href="#" class="ti ti-trash text-danger remove-account"></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td class="text-end"><strong>{{ __('Total Credit') }}
                                            ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="text-end totalCredit">{{ $journalEntry->totalCredit() }}</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="text-end"><strong>{{ __('Total Debit') }}
                                            ({{ \Auth::user()->currencySymbol() }})</strong></td>
                                    <td class="text-end totalDebit">{{ $journalEntry->totalDebit() }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template id="account-template">
        <tr>
            <td width="25%">
                {{ Form::hidden('id', '', ['class' => 'form-control id']) }}
                <div class="form-group">
                    <select class="form-control select2" name="account" required>
                        @foreach ($accounts as $key => $account)
                            <option value="{{ $key }}">{{ $account }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group price-input">
                    <input class="form-control debit" required="required" placeholder="Debit" name="debit" type="text" value="0">
                </div>
            </td>
            <td>
                <div class="form-group price-input">
                    <input class="form-control credit" required="required" placeholder="Credit" name="credit" type="text" value="0">
                </div>
            </td>
            <td>
                <div class="form-group">
                    {{ Form::text('description', '', ['class' => 'form-control', 'placeholder' => __('Description')]) }}
                </div>
            </td>
            <td class="text-end amount">
                0.00
            </td>
            <td>
                <a href="#" class="ti ti-trash text-danger remove-account"></a>
            </td>
        </tr>
    </template>

    <div class="modal-footer">
        <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('journal-entry.index') }}';"
            class="btn btn-light">
        <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
    </div>
    {{ Form::close() }}
@endsection

@push('script-page')
    <script>
        let lastSelectId = {{ $journalEntry->accounts->count() }}
        $(document).on('click', '#add-account', function() {
            let template = $($('#account-template').clone().html());

            new Choices(template.find('.select2')[0]);

            template.find('[name="id"]').attr('name', 'accounts[' + lastSelectId + '][id]');
            template.find('[name="account"]').attr('name', 'accounts[' + lastSelectId + '][account]');
            template.find('[name="debit"]').attr('name', 'accounts[' + lastSelectId + '][debit]');
            template.find('[name="credit"]').attr('name', 'accounts[' + lastSelectId + '][credit]');
            template.find('[name="description"]').attr('name', 'accounts[' + lastSelectId + '][description]');
            lastSelectId++;

            $('.ui-sortable').append(template);
        })

        $(document).on('click', '.remove-account', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        })

        $(document).on('keyup', '.debit', function() {
            var el = $(this).parent().parent().parent();
            var debit = $(this).val();
            var credit = 0;

            el.find('.credit').val(credit);
            el.find('.amount').html(debit);

            var inputs = $(".debit");
            var totalDebit = 0;
            for (var i = 0; i < inputs.length; i++) {
                totalDebit = parseFloat(totalDebit) + parseFloat($(inputs[i]).val());
            }
            $('.totalDebit').html(totalDebit.toFixed(2));

            el.find('.credit').attr("disabled", true);
            if (debit == '') {
                el.find('.credit').attr("disabled", false);
            }
        })

        $(document).on('keyup', '.credit', function() {
            var el = $(this).parent().parent().parent();
            var credit = $(this).val();
            var debit = 0;

            el.find('.debit').val(debit);
            el.find('.amount').html(credit);

            var inputs = $(".credit");
            var totalCredit = 0;
            for (var i = 0; i < inputs.length; i++) {
                totalCredit = parseFloat(totalCredit) + parseFloat($(inputs[i]).val());
            }
            $('.totalCredit').html(totalCredit.toFixed(2));

            el.find('.debit').attr("disabled", true);
            if (credit == '') {
                el.find('.debit').attr("disabled", false);
            }
        })
    </script>
@endpush
