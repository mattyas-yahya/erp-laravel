{{ Form::open(['route' => ['accounting.petty-cash.petty-cash.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('type', 'Tipe', ['class' => 'form-label']) !!}
            <br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" value="CASH_PAYMENT" name="type" id="inlineRadioType1" checked>
                <label class="form-check-label" for="inlineRadioType1">Cash Payment</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" value="CASH_RECEIVED" name="type" id="inlineRadioType2">
                <label class="form-check-label" for="inlineRadioType2">Cash Received</label>
            </div>
            <br>
            <br>
            {!! Form::label('petty_cash_number', 'Nomor', ['class' => 'form-label']) !!}
            <br>
            {!! Form::text('petty_cash_number', $pettyCashCashPaymentNumberCode, ['class' => 'form-control', 'readonly']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('received_by', 'Diterima', ['class' => 'form-label']) !!}
            <br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" value="Karyawan" name="received_by_type" id="inlineRadio1" checked>
                <label class="form-check-label" for="inlineRadio1">Karyawan</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" value="Umum" name="received_by_type" id="inlineRadio2">
                <label class="form-check-label" for="inlineRadio2">Umum</label>
            </div>
            <br>
            <br>
            {!! Form::label('', 'Nama Penerima', ['class' => 'form-label']) !!}
            <br>
            <div class="p0" id="received_by_name">
                {!! Form::text('received_by', null, ['class' => 'form-control', 'required']) !!}
            </div>
            <div class="p0" id="received_by_employee_id">
                <select class="form-control select2" name="received_by_employee_id" id="employee-options">
                    <option value=""></option>
                    @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('date', __('Date'), ['class' => 'form-label']) !!}
            <div class="form-icon-user">
                {{ Form::date('date', null, ['class' => 'form-control', 'required' => 'required']) }}
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('information', 'Keterangan', ['class' => 'form-label']) !!}
            {!! Form::text('information', null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script>
    $(function() {
        let pettyCashCashPaymentNumberCode = '{{ $pettyCashCashPaymentNumberCode }}'
        let pettyCashCashReceivedNumberCode = '{{ $pettyCashCashReceivedNumberCode }}'

        $('#received_by_employee_id').show();
        $('#received_by_name').hide();
        $('[name="received_by_employee_id"]').prop('required', true);
        $('[name="received_by"]').prop('required', null);

        $(document).on('change', '[name="type"]:checked', function() {
            let type = $(this).val();

            if ('CASH_PAYMENT' == type) {
                $('[name="petty_cash_number"]').val(pettyCashCashPaymentNumberCode);
            }

            if ('CASH_RECEIVED' == type) {
                $('[name="petty_cash_number"]').val(pettyCashCashReceivedNumberCode);
            }
        });

        $(document).on('change', '[name="received_by_type"]:checked', function() {
            let receivedByType = $(this).val();

            if ('Karyawan' == receivedByType) {
                $('#received_by_employee_id').show();
                $('#received_by_name').hide();
                $('[name="received_by_employee_id"]').prop('required', true);
                $('[name="received_by"]').prop('required', null);
            }

            if ('Umum' == receivedByType) {
                $('#received_by_name').show();
                $('#received_by_employee_id').hide();
                $('[name="received_by"]').prop('required', true);
                $('[name="received_by_employee_id"]').prop('required', null);
            }
        });
    });
</script>
