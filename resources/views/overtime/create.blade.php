{{ Form::open(['url' => 'overtime', 'method' => 'post']) }}
<div class="modal-body">
    {{ Form::hidden('employee_id', $employee->id, []) }}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('type', __('Overtime Type'), ['class' => 'form-label']) }} <span class="text-danger">*</span>
            <select class="form-control select2" name="type" id="type" required>
                <option value=""> </option>
                @foreach ($payrollStaffOvertimes as $payrollStaffOvertime)
                    <option
                        value="{{ $payrollStaffOvertime->id }}"
                    >
                        {{ $payrollStaffOvertime->type }} | {{ __('Time Worked (hour)') }}: {{ floatval($payrollStaffOvertime->time_worked) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('title', __('Overtime Title'), ['class' => 'form-label']) }}<span
                class="text-danger">*</span>
            {{ Form::text('title', null, ['class' => 'form-control ', 'required' => 'required', 'readonly']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('number_of_days', __('Number Of Days'), ['class' => 'form-label']) }}
            {{ Form::number('number_of_days', null, ['class' => 'form-control ', 'required' => 'required', 'step' => '0.01']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('hours', __('Hours'), ['class' => 'form-label']) }}
            {{ Form::number('hours', null, ['class' => 'form-control ', 'required' => 'required', 'step' => '0.01', 'readonly']) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('rate', __('Rate'), ['class' => 'form-label']) }}
            {{ Form::number('rate', null, ['class' => 'form-control ', 'required' => 'required', 'step' => '0.01', 'readonly']) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('note', __('Note')) }}
            {{ Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => __('Enter Note')]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}

<script>
    var overtimeTypes = JSON.parse('{!! $payrollStaffOvertimes->toJson() !!}');

    $('#type').change(function () {
        var id = $(this).val();
        let selectedOvertimeType = overtimeTypes.find(type => type.id == id);

        $('#title').val(selectedOvertimeType?.type);
        $('#hours').val(+selectedOvertimeType?.time_worked);
        $('#rate').val((+selectedOvertimeType?.overtime_pay_total ?? 0) * $('#number_of_days').val());
    });

    $('#number_of_days').on("keyup", function() {
        var id = $('#type').val();
        let selectedOvertimeType = overtimeTypes.find(type => type.id == id);

        $('#rate').val((+selectedOvertimeType?.overtime_pay_total ?? 0) * $(this).val());
    });
</script>
