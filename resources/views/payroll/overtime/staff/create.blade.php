{{ Form::open(['route' => ['payroll.overtime.staff.store'], 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('type', __('Type'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('type', null, ['class' => 'form-control', 'required']) }}
        </div>
        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('time_worked', __('Time Worked'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <input class="form-control" required="" name="time_worked" type="number" id="time_worked" step=".01">
        </div>
        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('time_calculation', __('Time Calculation'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <input class="form-control" required="" name="time_calculation" type="number" id="time_calculation" step=".01">
        </div>
        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('overtime_pay_per_hour', __('Overtime Pay Per Hour'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <input class="form-control" required="" name="overtime_pay_per_hour" type="number" id="overtime_pay_per_hour" step=".01">
        </div>
        <div class="form-group col-lg-12 col-md-12">
            {{ Form::label('overtime_pay_total', __('Overtime Pay Total'), ['class' => 'form-label']) }}
            {!! Form::hidden('overtime_pay_total', 0) !!}
            <input class="form-control" required="" type="number" id="overtime_pay_total_text" step=".01" readonly>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
</div>
{{ Form::close() }}

<script>
    function overtimePayTotalFormula(quantity, pay) {
        return quantity * pay;
    }

    function overtimePayTotal() {
        let result = overtimePayTotalFormula(+$('#time_calculation').val(), +$('#overtime_pay_per_hour').val());

        $('#overtime_pay_total_text').val(result);
        $('[name="overtime_pay_total"]').val(result);
    }

    $('#time_calculation').on("keyup", function() {
        overtimePayTotal();
    });

    $('#overtime_pay_per_hour').on("keyup", function() {
        overtimePayTotal();
    });
</script>
