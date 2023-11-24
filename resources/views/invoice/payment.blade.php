{{ Form::open(['route' => ['invoice.payment', $invoice->id], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group  col-md-6">
            {{ Form::label('date', __('Date'), ['class' => 'form-label']) }}
            {{ Form::date('date', '', ['class' => 'form-control ', 'required' => 'required']) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('amount', __('Amount'), ['class' => 'form-label']) }}
            {{ Form::number('amount', $invoice->getDue(), ['class' => 'form-control', 'required' => 'required']) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('account_id', __('Account'), ['class' => 'form-label']) }}
            {{ Form::select('account_id', $accounts, null, ['class' => 'form-control select', 'required' => 'required']) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('reference', __('Reference'), ['class' => 'form-label']) }}
            {{ Form::text('reference', '', ['class' => 'form-control']) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('payment_method_id', __('Payment Method'), ['class' => 'form-label']) }}
            {{ Form::select('payment_method_id', $paymentMethods, null, ['class' => 'form-control select', 'required' => 'required']) }}
        </div>
        <div class="form-group  col-md-6">
            {{ Form::label('payment_reference_number', __('Payment Reference Number'), ['class' => 'form-label']) }}
            {{ Form::text('payment_reference_number', '', ['class' => 'form-control']) }}
        </div>
        <div class="row giro-box none m-0 p-0">
            <div class="form-group col-md-6 none">
                {{ Form::label('giro_number', __('Nomor Giro'), ['class' => 'form-label']) }}
                {{ Form::text('giro_number', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group  col-md-6 none">
                {{ Form::label('giro_date', __('Tanggal Giro'), ['class' => 'form-label']) }}
                {{ Form::date('giro_date', '', ['class' => 'form-control ']) }}
            </div>
        </div>
        <div class="row cheque-box none m-0 p-0">
            <div class="form-group col-md-6 none">
                {{ Form::label('cheque_number', __('Nomor Cek'), ['class' => 'form-label']) }}
                {{ Form::text('cheque_number', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group  col-md-6 none">
                {{ Form::label('cheque_date', __('Tanggal Cek'), ['class' => 'form-label']) }}
                {{ Form::date('cheque_date', '', ['class' => 'form-control ']) }}
            </div>
        </div>
        <div class="form-group  col-md-12">
            {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
            {{ Form::textarea('description', '', ['class' => 'form-control', 'rows' => 3]) }}
        </div>
        <div class="col-md-6">
            {{ Form::label('add_receipt', __('Payment Receipt'), ['class' => 'form-label']) }}
            <div class="choose-file form-group">
                <label for="file" class="form-label">
                    <input type="file" name="add_receipt" id="image" class="form-control">
                </label>
                <p class="upload_file"></p>
            </div>
        </div>


    </div>
    <div class="modal-footer">

        <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Add') }}" class="btn  btn-primary">
    </div>

</div>
{{ Form::close() }}

<script>
    $(function() {
        let paymentMethod = $('#payment_method_id :selected').text();

        $('.giro-box').hide();
        $('.cheque-box').hide();

        if ('Giro' === paymentMethod) {
            $('.giro-box').show();
        }

        if ('Cek' === paymentMethod) {
            $('.cheque-box').show();
        }

        $(document).on('change', '#payment_method_id', function() {
            paymentMethod = $(this).find(':selected').text();

            $('.giro-box').hide();
            $('.cheque-box').hide();
            $('.giro-box [name="giro_number"]').val('');
            $('.cheque-box [name="cheque_number"]').val('');
            $('.giro-box [name="giro_date"]').val('');
            $('.cheque-box [name="cheque_date"]').val('');

            if ('Giro' === paymentMethod) {
                $('.giro-box').show();
            }

            if ('Cek' === paymentMethod) {
                $('.cheque-box').show();
            }
        });
    });
</script>
