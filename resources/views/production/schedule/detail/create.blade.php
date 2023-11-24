{{ Form::open(['route' => ['production.schedule.detail.store', $schedule->id], 'method' => 'POST']) }}
<div class="modal-body">
    <div class="row">
        <input type="hidden" name="production_schedule_id" value="{{ $schedule->id }}">
        <div class="form-group col-md-12">
            {{ Form::label('job_order_number', 'Job Order', ['class' => 'form-label']) }}
            {{ Form::text('job_order_number', $schedule->job_order_number, ['class' => 'form-control', 'readonly']) }}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('coil_number', 'No. Coil', ['class' => 'form-label']) !!}
            {!! Form::text('coil_number', $schedule->salesOrderLine->gr_from_so->no_coil, ['class' => 'form-control', 'readonly']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('spec', __('Spec'), ['class' => 'form-label']) !!}
            {!! Form::text('spec', $schedule->salesOrderLine?->gr_from_so?->product_name, ['class' => 'form-control', 'readonly']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('production_remaining', 'Sisa Produksi (kg mill)', ['class' => 'form-label']) !!}
            {!! Form::text('production_remaining', $schedule->production_remaining, ['class' => 'form-control', 'readonly']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-3 col-md-3">
            {{ Form::label('dimension_t', 'T', ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('dimension_t', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-3 col-md-3">
            {{ Form::label('dimension_l', 'L', ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('dimension_l', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-3 col-md-3">
            {{ Form::label('dimension_p', 'P', ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('dimension_p', null, ['class' => 'form-control', 'required']) }}
        </div>

        <div class="form-group col-lg-3 col-md-3">
            {{ Form::label('pieces', 'Total Pcs', ['class' => 'form-label']) }} <span class="text-danger">*</span>
            {{ Form::text('pieces', null, ['class' => 'form-control', 'required']) }}
        </div>

    </div>
    <div class="row">
        <div class="form-group col-md-12">
            {!! Form::label('production_total_text', 'Total Produksi (kg mill)', ['class' => 'form-label']) !!}
            {!! Form::text('production_total_text', '', ['class' => 'form-control',  'readonly']) !!}
            {!! Form::hidden('production_total', 0) !!}
            <small class="text-danger production-total-alert d-none">Sisa produksi yang dihasilkan akan minus. Harap menyesuaikan total produksi dengan sisa produksi</small>
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('pack', 'Pack', ['class' => 'form-label']) !!} <span class="text-danger">*</span>
            {!! Form::text('pack', '', ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('description', 'Keterangan', ['class' => 'form-label']) !!}
            {!! Form::text('description', '', ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn btn-primary schedule-detail-form-submit" disabled>
</div>
{{ Form::close() }}

<script>
    function setProductionTotal(payload) {
        let result = productionTotalFormula(productionScheduleDetail);
        let productionRemaining = $('#production_remaining').val();

        if (result > productionRemaining) {
            $('.production-total-alert').removeClass('d-none');
            $('.schedule-detail-form-submit').prop('disabled', true);
        } else {
            $('.schedule-detail-form-submit').prop('disabled', false);
            $('.production-total-alert').addClass('d-none');
        }

        $('#production_total_text').val(result);
        $('[name="production_total"]').val(result);
    }

    $('#dimension_t').on("keyup", function() {
        productionScheduleDetail.t = this.value;
        productionScheduleDetail.l = $('#dimension_l').val();
        productionScheduleDetail.p = $('#dimension_p').val();
        productionScheduleDetail.pieces = $('#pieces').val();
        setProductionTotal(productionScheduleDetail);
    });

    $('#dimension_l').on("keyup", function() {
        productionScheduleDetail.t = $('#dimension_t').val();
        productionScheduleDetail.l = this.value;
        productionScheduleDetail.p = $('#dimension_p').val();
        productionScheduleDetail.pieces = $('#pieces').val();
        setProductionTotal(productionScheduleDetail);
    });

    $('#dimension_p').on("keyup", function() {
        productionScheduleDetail.t = $('#dimension_t').val();
        productionScheduleDetail.l = $('#dimension_l').val();
        productionScheduleDetail.p = this.value;
        productionScheduleDetail.pieces = $('#pieces').val();
        setProductionTotal(productionScheduleDetail);
    });

    $('#pieces').on("keyup", function() {
        productionScheduleDetail.t = $('#dimension_t').val();
        productionScheduleDetail.l = $('#dimension_l').val();
        productionScheduleDetail.p = $('#dimension_p').val();
        productionScheduleDetail.pieces = this.value;
        setProductionTotal(productionScheduleDetail);
    });
</script>
