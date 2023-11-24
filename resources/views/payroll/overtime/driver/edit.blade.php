{{ Form::model($overtime, ['route' => ['payroll.overtime.driver.update', $overtime->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('rite', __('Rite'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::number('rite', old('rite', $overtime->rite), ['class' => 'form-control', 'required']) }}
        </div>
        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('overtime_pay_per_hour', __('Overtime Pay Per Hour'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <input class="form-control" required="" name="overtime_pay_per_hour" type="number" id="overtime_pay_per_hour" step=".01" value="{{ old('type', round($overtime->overtime_pay_per_hour)) }}">
        </div>
        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('overtime_pay_total', __('Overtime Pay Total'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <input class="form-control" required="" name="overtime_pay_total" type="number" id="overtime_pay_total" step=".01" value="{{ old('type', round($overtime->overtime_pay_total)) }}" readonly>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script>
    function overtimePayTotalFormula(quantity, pay) {
        return quantity * pay;
    }

    function overtimePayTotal() {
        let result = overtimePayTotalFormula(+$('#rite').val(), +$('#overtime_pay_per_hour').val());

        $('#overtime_pay_total_text').val(result);
        $('[name="overtime_pay_total"]').val(result);
    }

    $('#rite').on("keyup", function() {
        overtimePayTotal();
    });

    $('#overtime_pay_per_hour').on("keyup", function() {
        overtimePayTotal();
    });
</script>
